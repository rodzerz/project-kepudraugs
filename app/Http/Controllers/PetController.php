<?php


namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class PetController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $pets = Auth::user()
            ->pets()
            ->with('images')
            ->get();

        return view('pets.index', compact('pets'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        return view('pets.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'special_requirements' => 'nullable|string|max:10000',

            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $uploadedPaths = [];

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                &$uploadedPaths
            ) {
                $pet = Auth::user()->pets()->create([
                    'name' => $validated['name'],
                    'species' => $validated['species'],
                    'breed' => $validated['breed'] ?? null,
                    'age' => $validated['age'] ?? null,
                    'weight' => $validated['weight'] ?? null,
                    'special_requirements' =>
                        $validated['special_requirements'] ?? null,
                ]);

                if ($request->hasFile('images')) {
                    foreach ($request->file('images') as $image) {
                        $path = $image->store('pets', 'public');

                        if ($path === false) {
                            throw new RuntimeException(
                                'Neizdevās saglabāt mājdzīvnieka attēlu.'
                            );
                        }

                        $uploadedPaths[] = $path;

                        $pet->images()->create([
                            'image' => $path,
                        ]);
                    }
                }
            });
        } catch (Throwable $exception) {
            foreach ($uploadedPaths as $path) {
                try {
                    Storage::disk('public')->delete($path);
                } catch (Throwable $cleanupException) {
                    report($cleanupException);
                }
            }

            report($exception);

            return back()
                ->withInput($request->except('images'))
                ->with(
                    'error',
                    'Neizdevās pievienot mājdzīvnieku. Lūdzu, mēģini vēlreiz.'
                );
        }

        return redirect('/pets')
            ->with('success', 'Mājdzīvnieks veiksmīgi pievienots!');
    }

    // MĀJDZĪVNIEKA REDIĢĒŠANAS LAPA

    public function edit($pet)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $pet = Pet::with('images')->findOrFail($pet);

        // Lietotājs drīkst rediģēt tikai savu mājdzīvnieku.
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        return view('pets.edit', compact('pet'));
    }

    // MĀJDZĪVNIEKA INFORMĀCIJAS SAGLABĀŠANA

    public function update(Request $request, $pet)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $pet = Pet::findOrFail($pet);

        // Neļauj rediģēt cita lietotāja mājdzīvnieku.
        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0|max:999.99',
            'special_requirements' => 'nullable|string|max:10000',
        ]);

        $pet->update([
            'name' => $validated['name'],
            'species' => $validated['species'],
            'breed' => $validated['breed'] ?? null,
            'age' => $validated['age'] ?? null,
            'weight' => $validated['weight'] ?? null,
            'special_requirements' =>
                $validated['special_requirements'] ?? null,
        ]);

        return redirect('/pets')
            ->with('success', 'Mājdzīvnieka informācija veiksmīgi atjaunināta!');
    }

    public function destroy($pet)
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $pet = Pet::with('images')->findOrFail($pet);

        if ($pet->user_id !== Auth::id()) {
            abort(403);
        }

        $imagePaths = $pet->images
            ->pluck('image')
            ->filter()
            ->all();

        $pet->delete();

        foreach ($imagePaths as $path) {
            Storage::disk('public')->delete($path);
        }

        return redirect('/pets')
            ->with('success', 'Mājdzīvnieks veiksmīgi izdzēsts!');
    }
}
