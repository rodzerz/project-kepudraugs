<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $users = User::latest()->get();

        return view('admin.index', compact('users'));
    }

    public function toggleBlock($user)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }

        $user = User::findOrFail($user);

        // Administrators nevar bloķēt paši sevi
        if ($user->id === Auth::id()) {
            return redirect('/admin')
                ->with('error', 'Administrators nevar bloķēt pats sevi!');
        }

        $user->update([
            'is_blocked' => !$user->is_blocked,
        ]);

        $message = $user->is_blocked
            ? 'Lietotājs ir bloķēts!'
            : 'Lietotājs ir atbloķēts!';

        return redirect('/admin')->with('success', $message);
    }
}