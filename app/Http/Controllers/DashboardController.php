<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function index()
    {
        if (!Auth::user()) {
            return redirect('login');
        } else {
            if (Auth::user()->role == 'admin') {
                Log::info('admin');
                $users = User::where('role', '!=', 'admin')->get();
                return view('admin.dashboard', [
                    'users' => $users,
                ]);
            } else {
                Log::info('user');
                $user = User::where(['id' => Auth::user()->id])->first();
                return view('user.dashboard', ['user' => $user]);
            }
        }
    }

    public function edit($id)
    {
        if (isset($id) && $id != null && is_numeric($id)) {
            return User::where('id', $id)->first();
        } else {
            return redirect()->route('user');
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        if (isset($id) && $id != null && is_numeric($id)) {
            $this->validate($request, [
                'firstName' => 'required|regex:/^[a-zA-Z ]*$/',
                'lastName' => 'required|regex:/^[a-zA-Z ]*$/',
                'image' => 'required|image|max:1024',
            ]);

            // $path = $request->file('image')->storePublicly('data/demo', 'do');
            // $url = Storage::disk('do')->url($path);

            // Log::info($path);
            // Log::info($url);
            // Log::info(Storage::disk('do')->getVisibility('data/demo'));

            $user = User::where('id', $id)->first();
            $update = $user->update([
                'first_name' =>
                    $request->input('firstName') ?? $user->first_name,
                'last_name' => $request->input('lastName') ?? $user->last_name,
                'image' => $path ?? null,
            ]);

            $request
                ->session()
                ->flash('message', 'Record Updated Successfully');
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect()->route('user');
        }
    }

    public function userDelete(Request $request, $id): JsonResponse
    {
        if (isset($id) && $id != null && is_numeric($id)) {
            $delete = User::find($id)->delete();
            $request
                ->session()
                ->flash('message', 'Record deleted Successfully');
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect()->route('admin');
        }
    }
    public function updateUserRole(Request $request, $id): JsonResponse
    {
        if (isset($id) && $id != null && is_numeric($id)) {
            $delete = User::find($id)->update(['role' => 'admin']);
            $request
                ->session()
                ->flash('message', 'user promoted to admin Successfully');
            return response()->json([
                'status' => 200,
            ]);
        } else {
            return redirect()->route('admin');
        }
    }
}
