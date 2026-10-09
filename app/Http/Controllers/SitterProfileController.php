<?php


namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\SitterProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SitterProfileController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $profile = Auth::user()->sitterProfile;

        return view('sitter-profile.create', compact('profile'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'description' => 'nullable|string|max:65535',
            'experience' => 'nullable|string|max:65535',
            'price' => 'required|numeric|min:0|max:999999.99',
            'accepted_animals' => 'required|string|max:255',
        ]);

        $existingProfile = Auth::user()->sitterProfile;

        Auth::user()->sitterProfile()->updateOrCreate(
            ['user_id' => Auth::id()],
            $validated
        );

        $message = $existingProfile
            ? 'Pieskatītāja profils veiksmīgi atjaunināts!'
            : 'Pieskatītāja profils veiksmīgi izveidots!';

        return redirect('/dashboard')
            ->with('success', $message);
    }

    public function show()
    {
        if (Auth::user()->role !== 'sitter') {
            abort(403);
        }

        $profile = Auth::user()->sitterProfile;

        if (!$profile) {
            return redirect('/sitter-profile/create');
        }

        // Ielādē ne vairāk kā 10 atsauksmes vienā lapā.
        $reviews = Review::where('sitter_id', Auth::id())
            ->with('owner')
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10);

        // Vidējo vērtējumu aprēķina no VISĀM atsauksmēm.
        $averageRating = Review::where('sitter_id', Auth::id())
            ->avg('rating');

        return view('sitter-profile.show', compact(
            'profile',
            'reviews',
            'averageRating'
        ));
    }

    public function index(Request $request)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $query = SitterProfile::with('user')
            ->whereHas('user', function ($query) {
                $query->where('is_blocked', false)
                    ->where('role', 'sitter');
            });

        if ($request->filled('city')) {
            $query->where(
                'city',
                'like',
                '%' . $request->city . '%'
            );
        }

        // Atsauksmju statistika tiek aprēķināta datubāzē.
        // Sasaistām pēc user_id, jo Review glabā sitter_id.
        $query->addSelect([
            'average_rating' => Review::query()
                ->selectRaw('AVG(rating)')
                ->whereColumn(
                    'reviews.sitter_id',
                    'sitter_profiles.user_id'
                ),

            'reviews_count' => Review::query()
                ->selectRaw('COUNT(*)')
                ->whereColumn(
                    'reviews.sitter_id',
                    'sitter_profiles.user_id'
                ),
        ]);

        if ($request->filled('min_rating')) {
            $minRating = (float) $request->min_rating;

            $query->whereRaw(
                '(SELECT AVG(rating)
                  FROM reviews
                  WHERE reviews.sitter_id = sitter_profiles.user_id) >= ?',
                [$minRating]
            );
        }

        if ($request->price_sort === 'low_to_high') {
            $query->orderBy('price', 'asc');
        }

        if ($request->price_sort === 'high_to_low') {
            $query->orderBy('price', 'desc');
        }

        // Nodrošina stabilu secību arī vienādu cenu gadījumā.
        $query->orderBy('sitter_profiles.id', 'asc');

        // Vienā lapā attēlo 12 pieskatītājus.
        // Saglabā filtrus un kārtošanu, pārejot uz citu lapu.
        $profiles = $query
            ->paginate(12)
            ->withQueryString();

        return view(
            'sitter-profile.index',
            compact('profiles')
        );
    }
}
