<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('profile.password');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'different:current_password',
            ],
        ], [
            'current_password.required' =>
                'Ievadi pašreizējo paroli.',

            'current_password.current_password' =>
                'Pašreizējā parole nav pareiza.',

            'password.required' =>
                'Ievadi jauno paroli.',

            'password.min' =>
                'Jaunajai parolei jābūt vismaz 8 simbolus garai.',

            'password.confirmed' =>
                'Jaunās paroles nesakrīt.',

            'password.regex' =>
                'Parolē jābūt vismaz vienam lielajam burtam un vienam ciparam.',

            'password.different' =>
                'Jaunajai parolei jāatšķiras no pašreizējās.',
        ]);

        $user = $request->user();

        $user->password = Hash::make($validated['password']);
        $user->save();

        // Atjauno sesiju pēc paroles maiņas.
        $request->session()->regenerate();

        return redirect('/profile')
            ->with('success', 'Parole veiksmīgi nomainīta!');
    }
}
