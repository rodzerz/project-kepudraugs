<?php


namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;

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

        // Atzīmē saņemtās ziņas kā izlasītas.
        $booking->messages()
            ->where('receiver_id', Auth::id())
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        // Vienā lapā rāda 20 ziņojumus.
        // Vispirms atlasa jaunākos ziņojumus.
        $messages = $booking->messages()
            ->with(['sender', 'receiver'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(20);

        // Atlasītos ziņojumus attēlo hronoloģiskā secībā.
        $messages->setCollection(
            $messages->getCollection()->reverse()->values()
        );

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

        // Katram lietotājam savs ziņojumu ierobežojums.
        $rateLimitKey = 'messages:user:' . Auth::id();

        // Maksimums 10 ziņojumi 60 sekundēs.
        if (RateLimiter::tooManyAttempts($rateLimitKey, 10)) {
            $seconds = RateLimiter::availableIn($rateLimitKey);

            return back()
                ->withInput()
                ->withErrors([
                    'message' => 'Tu sūti ziņojumus pārāk ātri. '
                        . 'Mēģini vēlreiz pēc '
                        . $seconds . ' sekundēm.',
                ]);
        }

        $receiverId = $booking->owner_id === Auth::id()
            ? $booking->sitter_id
            : $booking->owner_id;

        $booking->messages()->create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $validated['message'],
        ]);

        // Skaitītāju palielina tikai pēc veiksmīgas saglabāšanas.
        RateLimiter::hit($rateLimitKey, 60);

        // Atgriežas uz pirmo lapu ar jaunākajām ziņām.
        return redirect('/bookings/' . $booking->id . '/messages');
    }
}
