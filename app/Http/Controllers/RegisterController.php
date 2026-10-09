<?php


namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class RegisterController extends Controller
{
    public function show()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Ierobežojums: 5 reģistrācijas mēģinājumi 1 stundā no vienas IP adreses.
        $key = 'register:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            $minutes = (int) ceil($seconds / 60);

            return back()
                ->withErrors([
                    'email' => 'Pārāk daudz reģistrācijas mēģinājumu. '
                        . 'Mēģiniet vēlreiz pēc '
                        . $minutes . ' minūtēm.',
                ])
                ->onlyInput('name', 'email', 'role');
        }

        // Uzskaita katru iesniegto reģistrācijas mēģinājumu.
        RateLimiter::hit($key, 3600);

        $validated = $request->validate([
            'name' => 'required|string|max:255|regex:/[a-zA-ZĀ-ž]/',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
            'role' => 'required|in:owner,sitter',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect('/register')
            ->with('success', 'Reģistrācija veiksmīga!');
    }
}
