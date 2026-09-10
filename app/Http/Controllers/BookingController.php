<?php


namespace App\Http\Controllers;

use App\Models\Booking;
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

        Booking::create([
            'owner_id' => Auth::id(),
            'sitter_id' => $validated['sitter_id'],
            'pet_type' => $validated['pet_type'],
            'booking_date' => $validated['booking_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return redirect('/dashboard')
            ->with('success', 'Rezervācijas pieprasījums veiksmīgi nosūtīts!');
    }
}

