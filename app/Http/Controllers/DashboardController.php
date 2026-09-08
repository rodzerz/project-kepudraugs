<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'owner') {
            return view('dashboard.owner');
        }

        if ($user->role === 'sitter') {
            return view('dashboard.sitter');
        }

        return redirect('/');
    }
}