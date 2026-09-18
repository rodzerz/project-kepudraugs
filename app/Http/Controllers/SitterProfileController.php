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
        return view('sitter-profile.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'city' => 'required|string|max:255',
            'description' => 'nullable|string',
            'experience' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'accepted_animals' => 'required|string|max:255',
        ]);

        Auth::user()->sitterProfile()->create($validated);

        return redirect('/dashboard')
            ->with('success', 'Pieskatītāja profils veiksmīgi izveidots!');
    }

    public function show()
    {
        $profile = Auth::user()->sitterProfile;

        if (!$profile) {
            return redirect('/sitter-profile/create');
        }

        $reviews = Review::where('sitter_id', Auth::id())
            ->with('owner')
            ->latest()
            ->get();

        $averageRating = $reviews->avg('rating');

        return view('sitter-profile.show', compact(
            'profile',
            'reviews',
            'averageRating'
        ));
    }

    public function index(Request $request)
    {
        $query = SitterProfile::with('user');

        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->city . '%');
        }

        $profiles = $query->get();

        foreach ($profiles as $profile) {

            $reviews = Review::where('sitter_id', $profile->user_id)->get();

            $profile->average_rating = $reviews->avg('rating');
            $profile->reviews_count = $reviews->count();
        }

        return view('sitter-profile.index', compact('profiles'));
    }
}