<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
// use Monolog\Logger;
// use Monolog\Handler\StreamHandler;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPassword;
use App\Mail\ConfirmEmail;
use Illuminate\Support\Str;


class LoginController extends Controller
{
    public function index()
    {
        // if (session()->has('email')) {
        //     return redirect('dashboard');
        // } else {
        //     return view('login');
        // }

        if (Redis::get('email')) {
            return redirect('dashboard');
        } else {
            return view('login');
        }
    }

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
            $email = User::where('email', $request->email)->first();
            // $request->session()->put('email', $email->email);
            Redis::set('email', $email->email);
            // Log::info(file_put_contents('php://stdout', 'Hello world abc'));

            // $log = new Logger('stdout');
            // $log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
            // $log->debug('Foo');

            if ($email->role == 'admin') {
                return redirect('dashboard');
            } else {
                return redirect('user-dashboard');
            }
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
        // if (session()->has('email')) {
        //     session()->pull('email');
        //     return redirect('login');
        // }

        if (Redis::get('email')) {
            Redis::del('email');
            return redirect('login');
        }
    }

    public function resetPassword()
    {
        return view('reset_password');
    }

    public function resetPasswordAction(Request $request)
    {
        $email = $request->email;
        $checkEmail = User::where('email', $email)->first();
        $token = Str::random(64);
        if ($checkEmail) {
            Mail::to($checkEmail->email)->send(new ResetPassword($checkEmail,$token));
        } else {
            return back()
                ->withErrors([
                    'email' =>
                        'The provided credentials do not match our records.',
                ])
                ->onlyInput('email');
        }
    }

    public function resetPasswordView($token)
    {
        return view('reset_password_view',['token' => $token]);
    }

    public function resetPasswordConfirm(Request $request)
    {
        // regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|min:8|max:16
        $this->validate(
            $request,
            [
                'old_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required|same:new_password',
            ],
            [
                // 'new_pass.regex' =>
                //     'One small,capital,digit and special charachter required',
                'confirm_password.same' =>
                    'The confirm password and new password must match',
            ]
        );
        $email = Auth::user()->email;
        $old_pass = $request->input('old_password');
        $query = User::where('email', $email)->first('password');
        $dbpass = Hash::check($old_pass, $query->password);

        if (Hash::check($old_pass, $query->password)) {
            $new_pass = Hash::make($request->input('new_password'));
            $updatePassword = User::where('email', $email)->update([
                'password' => $new_pass,
            ]);
            $data = User::where('email', $email)->first();

            if ($updatePassword) {
                Mail::to($data)->send(new ConfirmEmail($data));
            } else {
                return back();
            }
        } else {
            return back()->withErrors([
                'old_password' => 'old password do not match our records.',
            ]);
        }
    }
}
