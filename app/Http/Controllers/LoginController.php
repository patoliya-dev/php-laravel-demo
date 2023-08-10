<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;

class LoginController extends Controller
{
    public function login(Request $request)
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
            return redirect('dashboard')->with('message','login successfully');
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

    public function logout()
    {
        if (Auth::user()) {
            Auth::logout();
            return redirect('login');
        }
    }
}
