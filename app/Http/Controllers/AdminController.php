<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Booking;
use App\Models\Pet;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::latest()->get();

        // Lietotāju statistika
        $totalUsers = User::count();

        $totalOwners = User::where('role', 'owner')->count();

        $totalSitters = User::where('role', 'sitter')->count();

        $blockedUsers = User::where('is_blocked', true)->count();

        // Rezervāciju statistika
        $totalBookings = Booking::count();

        $pendingBookings = Booking::where('status', 'pending')->count();

        $acceptedBookings = Booking::where('status', 'accepted')->count();

        $completedBookings = Booking::where('status', 'completed')->count();

        $cancelledBookings = Booking::where('status', 'cancelled')->count();

        $rejectedBookings = Booking::where('status', 'rejected')->count();

        return view('admin.index', compact(
            'users',
            'totalUsers',
            'totalOwners',
            'totalSitters',
            'blockedUsers',
            'totalBookings',
            'pendingBookings',
            'acceptedBookings',
            'completedBookings',
            'cancelledBookings',
            'rejectedBookings'
        ));
    }

    public function toggleBlock($user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($user);

        // Administrators nevar bloķēt pats sevi
        if ($user->id === Auth::id()) {
            return redirect('/admin')
                ->with(
                    'error',
                    'Administrators nevar bloķēt pats sevi!'
                );
        }

        $user->update([
            'is_blocked' => !$user->is_blocked,
        ]);

        $message = $user->is_blocked
            ? 'Lietotājs ir bloķēts!'
            : 'Lietotājs ir atbloķēts!';

        return redirect('/admin')->with('success', $message);
    }

    public function bookings()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $bookings = Booking::with(['owner', 'sitter'])
            ->latest()
            ->get();

        return view('admin.bookings', compact('bookings'));
    }

    public function pets()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pets = Pet::with(['user', 'images'])
            ->latest()
            ->get();

        return view('admin.pets', compact('pets'));
    }

    public function deletePet($pet)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $pet = Pet::with('images')->findOrFail($pet);

        // Izdzēš mājdzīvnieka attēlu failus no storage
        foreach ($pet->images as $image) {
            if ($image->image) {
                Storage::disk('public')->delete($image->image);
            }
        }

        // Izdzēš mājdzīvnieku.
        // pet_images ieraksti tiek dzēsti ar cascade.
        $pet->delete();

        return redirect('/admin/pets')
            ->with(
                'success',
                'Mājdzīvnieks un tā saturs ir veiksmīgi noņemts!'
            );
    }
}