<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(Request $request)
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

        // $path = $request->file('image_file')->storePublicly('data/demo', 'do');
        // $url = Storage::disk('do')->url($path);

        // Log::info($path);
        // Log::info($url);
        // Log::info(Storage::disk('do')->getVisibility('data/demo'));

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
    }
}
