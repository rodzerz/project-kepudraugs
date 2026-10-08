
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Message;
use App\Models\SitterProfile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function create($sitter)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $sitterProfile = SitterProfile::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'sitter')
                    ->where('is_blocked', false);
            })
            ->findOrFail($sitter);

        return view('bookings.create', compact('sitterProfile'));
    }

    public function index()
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $bookings = Auth::user()->ownerBookings()
            ->with('sitter')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function sitterBookings()
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $bookings = Auth::user()->sitterBookings()
            ->with('owner')
            ->latest()
            ->get();

        return view('bookings.sitter', compact('bookings'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'sitter_id' => 'required|integer|exists:users,id',
            'pet_type' => 'required|string|max:255',
            'booking_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'message' => 'nullable|string|max:5000',
        ]);

        $bookingStart = Carbon::parse(
            $validated['booking_date'] . ' ' . $validated['start_time']
        );

        if ($bookingStart->lessThanOrEqualTo(now())) {
            throw ValidationException::withMessages([
                'start_time' => 'Rezervācijas sākuma laikam jābūt nākotnē.',
            ]);
        }

        DB::transaction(function () use ($validated) {

            /*
            |--------------------------------------------------------------------------
            | Bloķē pieskatītāja lietotāja ierakstu transakcijas laikā
            |--------------------------------------------------------------------------
            |
            | Visi vienlaicīgie rezervāciju izveides pieprasījumi vienam
            | pieskatītājam tiek apstrādāti secīgi.
            |
            */

            $sitter = User::whereKey($validated['sitter_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($sitter->role !== 'sitter' || $sitter->is_blocked) {
                throw ValidationException::withMessages([
                    'sitter_id' => 'Izvēlētais pieskatītājs nav pieejams.',
                ]);
            }

            $sitterProfileExists = SitterProfile::where(
                'user_id',
                $sitter->id
            )->exists();

            if (!$sitterProfileExists) {
                throw ValidationException::withMessages([
                    'sitter_id' => 'Izvēlētajam pieskatītājam nav profila.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Pārbauda laika pārklāšanos
            |--------------------------------------------------------------------------
            */

            $hasConflict = Booking::where('sitter_id', $sitter->id)
                ->where('booking_date', $validated['booking_date'])
                ->whereIn('status', ['pending', 'accepted'])
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time'])
                ->exists();

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'booking_date' =>
                        'Šajā datumā un laikā pieskatītājs jau ir aizņemts.',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Izveido rezervāciju
            |--------------------------------------------------------------------------
            */

            $booking = Booking::create([
                'owner_id' => Auth::id(),
                'sitter_id' => $sitter->id,
                'pet_type' => $validated['pet_type'],
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'message' => $validated['message'] ?? null,
                'status' => 'pending',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Sākotnējā ziņa tajā pašā transakcijā
            |--------------------------------------------------------------------------
            */

            if (!empty($validated['message'])) {
                Message::create([
                    'booking_id' => $booking->id,
                    'sender_id' => Auth::id(),
                    'receiver_id' => $sitter->id,
                    'message' => $validated['message'],
                ]);
            }

        }, 3);

        return redirect('/dashboard')
            ->with(
                'success',
                'Rezervācijas pieprasījums veiksmīgi nosūtīts!'
            );
    }

    public function accept($booking)
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        DB::transaction(function () use ($booking) {

            $reservation = Booking::findOrFail($booking);

            if ($reservation->sitter_id !== Auth::id()) {
                abort(403);
            }

            // Izmanto to pašu pieskatītāja bloķēšanas kārtību
            // kā rezervācijas izveidē.
            User::whereKey(Auth::id())
                ->lockForUpdate()
                ->firstOrFail();

            $reservation = Booking::whereKey($booking)
                ->lockForUpdate()
                ->firstOrFail();

            if ($reservation->status !== 'pending') {
                throw ValidationException::withMessages([
                    'booking' => 'Šo rezervāciju vairs nevar pieņemt.',
                ]);
            }

            $reservationStart = Carbon::parse(
                $reservation->booking_date . ' ' . $reservation->start_time
            );

            if ($reservationStart->lessThanOrEqualTo(now())) {
                throw ValidationException::withMessages([
                    'booking' => 'Rezervāciju ar pagājušu sākuma laiku nevar pieņemt.',
                ]);
            }

            $hasConflict = Booking::where(
                'sitter_id',
                $reservation->sitter_id
            )
                ->whereKeyNot($reservation->id)
                ->where('booking_date', $reservation->booking_date)
                ->where('status', 'accepted')
                ->where('start_time', '<', $reservation->end_time)
                ->where('end_time', '>', $reservation->start_time)
                ->exists();

            if ($hasConflict) {
                throw ValidationException::withMessages([
                    'booking' =>
                        'Šajā laikā jau ir cita apstiprināta rezervācija.',
                ]);
            }

            $reservation->update([
                'status' => 'accepted',
            ]);

        }, 3);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija ir pieņemta!');
    }

    public function reject($booking)
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $reservation = Booking::findOrFail($booking);

        if ($reservation->sitter_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->status !== 'pending') {
            return redirect('/bookings/sitter')
                ->with('error', 'Šo rezervāciju vairs nevar noraidīt!');
        }

        $reservation->update([
            'status' => 'rejected',
        ]);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija ir noraidīta!');
    }

    public function complete($booking)
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $reservation = Booking::findOrFail($booking);

        if ($reservation->sitter_id !== Auth::id()) {
            abort(403);
        }

        if ($reservation->status !== 'accepted') {
            return redirect('/bookings/sitter')
                ->with('error', 'Šo rezervāciju nevar atzīmēt kā pabeigtu!');
        }

        $reservationEnd = Carbon::parse(
            $reservation->booking_date . ' ' . $reservation->end_time
        );

        if ($reservationEnd->isFuture()) {
            return redirect('/bookings/sitter')
                ->with(
                    'error',
                    'Rezervāciju var pabeigt tikai pēc tās beigu laika!'
                );
        }

        $reservation->update([
            'status' => 'completed',
        ]);

        return redirect('/bookings/sitter')
            ->with(
                'success',
                'Rezervācija ir atzīmēta kā pabeigta!'
            );
    }

    public function cancel($booking)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $reservation = Booking::findOrFail($booking);

        if ($reservation->owner_id !== Auth::id()) {
            abort(403);
        }

        if (!in_array($reservation->status, ['pending', 'accepted'])) {
            return redirect('/bookings')
                ->with('error', 'Šo rezervāciju vairs nevar atcelt!');
        }

        $reservationStart = Carbon::parse(
            $reservation->booking_date . ' ' . $reservation->start_time
        );

        if ($reservationStart->lessThanOrEqualTo(now())) {
            return redirect('/bookings')
                ->with(
                    'error',
                    'Rezervāciju nevar atcelt pēc tās sākuma laika!'
                );
        }

        $reservation->update([
            'status' => 'cancelled',
        ]);

        return redirect('/bookings')
            ->with('success', 'Rezervācija ir atcelta!');
    }
}
