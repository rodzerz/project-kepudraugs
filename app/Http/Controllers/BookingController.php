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
        $sitterProfile = SitterProfile::with('user')->findOrFail($sitter);

        return view('bookings.create', compact('sitterProfile'));
    }

    public function index()
    {
        $bookings = Auth::user()->ownerBookings()
            ->with('sitter')
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function sitterBookings()
    {
        $bookings = Auth::user()->sitterBookings()
            ->with('owner')
            ->latest()
            ->get();

        return view('bookings.sitter', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sitter_id' => 'required|exists:users,id',
            'pet_type' => 'required|string|max:255',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'message' => 'nullable|string',
        ]);

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

        if (!empty($validated['message'])) {

            Message::create([
                'booking_id' => $booking->id,
                'sender_id' => Auth::id(),
                'receiver_id' => $validated['sitter_id'],
                'message' => $validated['message'],
            ]);
        }

        return redirect('/dashboard')
            ->with('success', 'Rezervācijas pieprasījums veiksmīgi nosūtīts!');
    }

    public function accept($booking)
    {
        $booking = Booking::findOrFail($booking);

        if ($booking->sitter_id !== Auth::id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'accepted',
        ]);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija ir pieņemta!');
    }

    public function reject($booking)
    {
        $booking = Booking::findOrFail($booking);

        if ($booking->sitter_id !== Auth::id()) {
            abort(403);
        }

        $booking->update([
            'status' => 'rejected',
        ]);

        return redirect('/bookings/sitter')
            ->with('success', 'Rezervācija ir noraidīta!');
    }

    public function cancel($booking)
    {
        $booking = Booking::findOrFail($booking);

        if ($booking->owner_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return redirect('/bookings')
                ->with('success', 'Šo rezervāciju vairs nevar atcelt!');
        }

        $booking->update([
            'status' => 'cancelled',
        ]);

        return redirect('/bookings')
            ->with('success', 'Rezervācija ir atcelta!');
    }
}