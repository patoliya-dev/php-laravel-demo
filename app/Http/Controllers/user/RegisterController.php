<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
// use Illuminate\Support\Facades\Crypt;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.register');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|min:8|max:16'

        $request->validate(
            [
                'firstName' => 'required|regex:/^[a-zA-Z ]*$/',
                'lastName' => 'required|regex:/^[a-zA-Z ]*$/',
                'email' => 'required|email|unique:users,email',
                'Password' => 'required',
                'image_file' => 'required|image|max:1024',
            ],
            [
                'email.unique' => 'Email is already exist',
                'Password.regex' =>
                    'One small,capital,digit and special charachter required',
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
        ]);

        return redirect('login');
    }
}
