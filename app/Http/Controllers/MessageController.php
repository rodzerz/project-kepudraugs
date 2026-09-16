<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function show($booking)
    {
        $booking = Booking::with(['owner', 'sitter'])
            ->findOrFail($booking);

        if (
            $booking->owner_id !== Auth::id() &&
            $booking->sitter_id !== Auth::id()
        ) {
            abort(403);
        }

        $booking->messages()
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        $messages = $booking->messages()
            ->with(['sender', 'receiver'])
            ->oldest()
            ->get();

        return view('messages.show', compact('booking', 'messages'));
    }

    public function store(Request $request, $booking)
    {
        $booking = Booking::findOrFail($booking);

        if (
            $booking->owner_id !== Auth::id() &&
            $booking->sitter_id !== Auth::id()
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $receiverId = $booking->owner_id === Auth::id()
            ? $booking->sitter_id
            : $booking->owner_id;

        $booking->messages()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $validated['message'],
        ]);

        return redirect('/bookings/' . $booking->id . '/messages');
    }
}