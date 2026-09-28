<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Message;
use App\Models\SitterProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function create($sitter)
    {
        // Tikai owner drīkst veidot rezervāciju
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $sitterProfile = SitterProfile::with('user')->findOrFail($sitter);

        return view('bookings.create', compact('sitterProfile'));
    }

    public function index()
    {
        // Tikai owner drīkst skatīt savas rezervācijas
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
        // Tikai sitter drīkst skatīt saņemtās rezervācijas
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
        // Tikai owner drīkst izveidot rezervāciju
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'sitter_id' => 'required|exists:users,id',
            'pet_type' => 'required|string|max:255',
            'booking_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'message' => 'nullable|string',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Pārbauda, vai izvēlētais lietotājs tiešām ir pieskatītājs
        |--------------------------------------------------------------------------
        */

        $sitterProfile = SitterProfile::where(
            'user_id',
            $validated['sitter_id']
        )->first();

        if (!$sitterProfile || $sitterProfile->user->role !== 'sitter') {
            return back()
                ->withInput()
                ->withErrors([
                    'sitter_id' => 'Izvēlētais lietotājs nav pieskatītājs.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Pārbauda laiku šodienai
        |--------------------------------------------------------------------------
        */

        if (
            $validated['booking_date'] === now()->format('Y-m-d') &&
            $validated['start_time'] <= now()->format('H:i')
        ) {
            return back()
                ->withInput()
                ->withErrors([
                    'start_time' =>
                        'Šodien rezervācijas sākuma laiks nevar būt pagātnē.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Pārbauda, vai pieskatītājam nav cita rezervācija tajā pašā laikā
        |--------------------------------------------------------------------------
        */

        $hasConflict = Booking::where(
            'sitter_id',
            $validated['sitter_id']
        )
            ->where(
                'booking_date',
                $validated['booking_date']
            )
            ->whereIn('status', ['pending', 'accepted'])
            ->where(function ($query) use ($validated) {
                $query
                    ->where(
                        'start_time',
                        '<',
                        $validated['end_time']
                    )
                    ->where(
                        'end_time',
                        '>',
                        $validated['start_time']
                    );
            })
            ->exists();

        if ($hasConflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'booking_date' =>
                        'Šajā datumā un laikā pieskatītājs jau ir aizņemts.'
                ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Izveido rezervāciju
        |--------------------------------------------------------------------------
        */

        $booking = Booking::create([
            'owner_id' => Auth::id(),
            'sitter_id' => $validated['sitter_id'],
            'pet_type' => $validated['pet_type'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Ja īpašnieks pievienoja ziņu, izveido arī sarakstes ziņu
        |--------------------------------------------------------------------------
        */

        if (!empty($validated['message'])) {
            Message::create([
                'booking_id' => $booking->id,
                'sender_id' => Auth::id(),
                'receiver_id' => $validated['sitter_id'],
                'message' => $validated['message'],
            ]);
        }

        return redirect('/dashboard')
            ->with(
                'success',
                'Rezervācijas pieprasījums veiksmīgi nosūtīts!'
            );
    }

    public function accept($booking)
    {
        // Tikai sitter drīkst pieņemt rezervāciju
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $booking = Booking::findOrFail($booking);

        // Sitter drīkst mainīt tikai sev adresētu rezervāciju
        if ($booking->sitter_id !== Auth::id()) {
            abort(403);
        }

        // Pieņemt drīkst tikai gaidošu rezervāciju
        if ($booking->status !== 'pending') {
            return redirect('/bookings/sitter')
                ->with(
                    'success',
                    'Šo rezervāciju vairs nevar pieņemt!'
                );
        }

        $booking->update([
            'status' => 'accepted',
        ]);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija ir pieņemta!');
    }

    public function reject($booking)
    {
        // Tikai sitter drīkst noraidīt rezervāciju
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $booking = Booking::findOrFail($booking);

        // Sitter drīkst mainīt tikai sev adresētu rezervāciju
        if ($booking->sitter_id !== Auth::id()) {
            abort(403);
        }

        // Noraidīt drīkst tikai gaidošu rezervāciju
        if ($booking->status !== 'pending') {
            return redirect('/bookings/sitter')
                ->with(
                    'success',
                    'Šo rezervāciju vairs nevar noraidīt!'
                );
        }

        $booking->update([
            'status' => 'rejected',
        ]);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija ir noraidīta!');
    }

    public function complete($booking)
    {
        // Tikai sitter drīkst pabeigt rezervāciju
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $booking = Booking::findOrFail($booking);

        // Sitter drīkst mainīt tikai sev adresētu rezervāciju
        if ($booking->sitter_id !== Auth::id()) {
            abort(403);
        }

        // Pabeigt drīkst tikai pieņemtu rezervāciju
        if ($booking->status !== 'accepted') {
            return redirect('/bookings/sitter')
                ->with(
                    'success',
                    'Šo rezervāciju nevar atzīmēt kā pabeigtu!'
                );
        }

        $booking->update([
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
        // Tikai owner drīkst atcelt rezervāciju
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $booking = Booking::findOrFail($booking);

        // Owner drīkst atcelt tikai savu rezervāciju
        if ($booking->owner_id !== Auth::id()) {
            abort(403);
        }

        // Atcelt drīkst tikai gaidošu rezervāciju
        if ($booking->status !== 'pending') {
            return redirect('/bookings')
                ->with(
                    'success',
                    'Šo rezervāciju vairs nevar atcelt!'
                );
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return redirect('/bookings')
            ->with('success', 'Rezervācija ir atcelta!');
    }
}