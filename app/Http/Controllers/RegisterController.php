<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmEmail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RegisterController extends Controller
{
    public function store(Request $request) :RedirectResponse
    {
        $request->validate(
            [
                'firstName' => 'required|regex:/^[a-zA-Z ]*$/',
                'lastName' => 'required|regex:/^[a-zA-Z ]*$/',
                'email' => 'required|email|unique:users,email',
                'Password' => 'required|min:8',
                'image_file' => 'required|image|max:1024',
            ],
            [
                'email.unique' => 'Email is already exist',
            ]
        );

        $path = $request->file('image_file')->storePublicly('data/demo', 'do');

        $create = User::create([
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'password' => hash::make($request->Password),
            'image' => $path ?? null,
            'role' => 'user',
            'token' => Str::random(60),
        ]);

        Mail::to($create->email)->send(new ConfirmEmail($create));
        return redirect('login')->with(
            'message',
            'your verification is in progress.., please check email in your inbox'
        );
    }
}
