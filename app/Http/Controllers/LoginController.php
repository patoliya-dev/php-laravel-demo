<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (
            Auth::attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])
        ) {
            return redirect('dashboard')->with('message', 'login successfully');
        } else {
            return back()
                ->withErrors([
                    'email' =>
                    'The provided credentials do not match our records.',
                    'password' => 'current password is not valid',
                ])
                ->onlyInput('password', 'email');
        }
    }

    public function logout(): RedirectResponse
    {
        if (Auth::user()) {
            Auth::logout();
            return redirect('login');
        }
    }
}
