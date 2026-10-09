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

        // Lietotāji: 20 ieraksti vienā lapā
        $users = User::orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(20);

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

        // Saglabā pašreizējās lapas numuru
        $page = max(1, (int) request()->input('page', 1));

        $redirectUrl = '/admin?page=' . $page;

        $user = User::findOrFail($user);

        // Administrators nevar bloķēt pats sevi
        if ($user->id === Auth::id()) {
            return redirect($redirectUrl)
                ->with(
                    'error',
                    'Administrators nevar bloķēt pats sevi!'
                );
        }

        // Administrators nevar bloķēt citu administratoru
        if ($user->role === 'admin') {
            return redirect($redirectUrl)
                ->with(
                    'error',
                    'Administratoru kontus nevar bloķēt!'
                );
        }

        // Bloķē vai atbloķē parastu lietotāju
        $user->update([
            'is_blocked' => !$user->is_blocked,
        ]);

        $message = $user->is_blocked
            ? 'Lietotājs ir bloķēts!'
            : 'Lietotājs ir atbloķēts!';

        // Atgriežas tajā pašā lietotāju saraksta lapā
        return redirect($redirectUrl)
            ->with('success', $message);
    }

    public function bookings()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Rezervācijas: 20 ieraksti vienā lapā
        $bookings = Booking::with(['owner', 'sitter'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.bookings', compact('bookings'));
    }

    public function pets()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Mājdzīvnieki: 20 ieraksti vienā lapā
        $pets = Pet::with(['user', 'images'])
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(20);

        return view('admin.pets', compact('pets'));
    }

    public function deletePet($pet)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        // Saglabā pašreizējās lapas numuru
        $page = max(1, (int) request()->input('page', 1));

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

        // Pēc dzēšanas pārbauda, cik lapas vēl palikušas.
        // Ja pēdējā lapa kļuvusi tukša, atgriežas iepriekšējā.
        $remainingPets = Pet::count();

        $lastPage = max(1, (int) ceil($remainingPets / 20));

        $page = min($page, $lastPage);

        return redirect('/admin/pets?page=' . $page)
            ->with(
                'success',
                'Mājdzīvnieks un tā saturs ir veiksmīgi noņemts!'
            );
    }
}
