<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {

            // Pārbauda, vai lietotājs nav bloķēts
            if (Auth::user()->is_blocked) {
                Auth::logout();

                return back()
                    ->withErrors([
                        'email' => 'Jūsu konts ir bloķēts. Sazinieties ar administratoru.',
                    ])
                    ->withInput();
            }

            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Nepareizs e-pasts vai parole.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}