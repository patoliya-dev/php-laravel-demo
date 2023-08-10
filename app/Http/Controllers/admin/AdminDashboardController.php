<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\Cache;
// use Illuminate\Support\Facades\DB;

use Illuminate\Http\JsonResponse;

class AdminDashboardController extends Controller
{
    public function usersShow()
    {
        // if (!session()->has('email')) {
        //     return redirect('login');
        // } else {
        //     $users = User::where('role', '!=', 'admin')->get();
        //     return view('admin.dashboard', ['users' => $users,'email' => Redis::get('email')]);
        // }

        if (!Redis::get('email')) {
            return redirect('login');
        } else {
            $users = User::where('role', '!=', 'admin')->get();
            return view('admin.dashboard', [
                'users' => $users,
                'email' => Redis::get('email'),
            ]);
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
