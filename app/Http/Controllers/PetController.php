<?php
namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetController extends Controller
{
    public function index()
    {
        $pets = Auth::user()->pets()->with('images')->get();

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        return view('pets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'special_requirements' => 'nullable|string',

            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $pet = Auth::user()->pets()->create([
            'name' => $validated['name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'age' => $validated['age'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'special_requirements' => $validated['special_requirements'] ?? null,
        ]);

        if ($request->hasFile('images')) {

            foreach ($request->file('images') as $image) {

                $path = $image->store('pets', 'public');

                $pet->images()->create([
                    'image' => $path,
                ]);
            }
        }

        return redirect('/pets')
            ->with('success', 'Mājdzīvnieks veiksmīgi pievienots!');
    }

    public function destroy($pet)
    {
        $pet = Pet::findOrFail($pet);

        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $pet->delete();

        return redirect('/pets')
            ->with('success', 'Mājdzīvnieks veiksmīgi izdzēsts!');
    }
}

