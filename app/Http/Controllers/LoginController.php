<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

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

        // Katram e-pastam un IP adresei ir savs ierobežojums.
        $key = Str::lower($credentials['email']) . '|' . $request->ip();

        // Pārbauda, vai pārsniegti 5 neveiksmīgi mēģinājumi.
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return back()
                ->withErrors([
                    'email' => 'Pārāk daudz pieslēgšanās mēģinājumu. Mēģiniet vēlreiz pēc '
                        . $seconds . ' sekundēm.',
                ])
                ->onlyInput('email');
        }

        if (Auth::attempt($credentials)) {

            if (Auth::user()->is_blocked) {
                Auth::logout();

                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()
                    ->withErrors([
                        'email' => 'Jūsu konts ir bloķēts. Sazinieties ar administratoru.',
                    ])
                    ->onlyInput('email');
            }

            // Veiksmīgas pieslēgšanās gadījumā notīra mēģinājumus.
            RateLimiter::clear($key);

            $request->session()->regenerate();

            // Administratoru nosūta uz administratora paneli.
            if (Auth::user()->role === 'admin') {
                return redirect('/admin');
            }

            // Pārējos lietotājus nosūta uz parasto paneli.
            return redirect('/dashboard');
        }

        // Reģistrē neveiksmīgu mēģinājumu.
        RateLimiter::hit($key, 60);

        return back()
            ->withErrors([
                'email' => 'Nepareizs e-pasts vai parole.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
