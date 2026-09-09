<?php

namespace App\Http\Controllers;

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

    return view('sitter-profile.show', compact('profile'));
}

public function index(Request $request)
{
    $query = \App\Models\SitterProfile::with('user');

    if ($request->filled('city')) {
        $query->where('city', 'like', '%' . $request->city . '%');
    }

    $profiles = $query->get();

    return view('sitter-profile.index', compact('profiles'));
}



} 