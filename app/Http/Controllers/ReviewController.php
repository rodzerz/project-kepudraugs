<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($booking)
    {
        $booking = Booking::with('sitter')
            ->findOrFail($booking);

        // Atsauksmi var pievienot tikai rezervācijas īpašnieks
        if ($booking->owner_id !== Auth::id()) {
            abort(403);
        }

        // Atsauksmi var pievienot tikai pabeigtai rezervācijai
        if ($booking->status !== 'accepted') {
            return redirect('/bookings')
                ->with('success', 'Atsauksmi var pievienot tikai pieņemtai rezervācijai!');
        }

        // Vienai rezervācijai var būt tikai viena atsauksme
        if ($booking->review()->exists()) {
            return redirect('/bookings')
                ->with('success', 'Šai rezervācijai atsauksme jau ir pievienota!');
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, $booking)
    {
        $booking = Booking::findOrFail($booking);

        // Tikai rezervācijas īpašnieks drīkst pievienot atsauksmi
        if ($booking->owner_id !== Auth::id()) {
            abort(403);
        }

        // Atsauksmi var pievienot tikai pieņemtai rezervācijai
        if ($booking->status !== 'accepted') {
            return redirect('/bookings')
                ->with('success', 'Atsauksmi var pievienot tikai pieņemtai rezervācijai!');
        }

        // Pārbauda, vai atsauksme jau nepastāv
        if ($booking->review()->exists()) {
            return redirect('/bookings')
                ->with('success', 'Šai rezervācijai atsauksme jau ir pievienota!');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:2000',
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'owner_id' => Auth::id(),
            'sitter_id' => $booking->sitter_id,
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? null,
        ]);

        return redirect('/bookings')
            ->with('success', 'Vērtējums un atsauksme veiksmīgi pievienoti!');
    }
}