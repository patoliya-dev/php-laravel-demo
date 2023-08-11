<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {

        if (Auth::user()->role == 'admin') {
            $users = User::where('role', 'user')->get();
            return view('admin.dashboard', compact('users'));
        } else {
            $user = User::find(Auth::user()->id);
            return view('user.dashboard', compact('user'));
        }
    }

    public function edit($id): JsonResponse
    {
        if (isset($id) && $id != null) {
            $user = User::find($id);
            return Response::json([
                'user' => $user,
            ]);
        } else {
            return redirect('dashboard');
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        if (isset($id) && $id != null) {
            $image_rule = 'nullable';
            if ($request->file('image') != null) {
                $image_rule .= '|image|max:1024';
            }
            $this->validate($request, [
                'firstName' => 'required|regex:/^[a-zA-Z ]*$/',
                'lastName' => 'required|regex:/^[a-zA-Z ]*$/',
                'image' => $image_rule,
            ]);

            $path = null;
            if ($request->file('image') != null) {
                $path = $request->file('image')->storePublicly('data/demo', 'do');
            }

            $user = User::find($id);
            $update = $user->update([
                'first_name' => $request->input('firstName') ?? $user->first_name,
                'last_name' => $request->input('lastName') ?? $user->last_name,
                'image' => $path ?? $user->image,
            ]);

            $request
                ->session()
                ->flash('message', 'Record Updated Successfully');
            return Response::json([
                'status' => 200,
            ]);
        } else {
            return redirect('dashboard');
        }
    }

    public function userDelete(Request $request, $id): JsonResponse
    {
        if (isset($id) && $id != null) {
            $delete = User::find($id)->delete();
            $request
                ->session()
                ->flash('message', 'Record deleted Successfully');
            return Response::json([
                'status' => 200,
            ]);
        } else {
            return redirect('dashboard');
        }
    }
    public function updateUserRole(Request $request, $id): JsonResponse
    {
        if (isset($id) && $id != null) {
            User::find($id)->update(['role' => 'admin']);
            $request
                ->session()
                ->flash('message', 'user promoted to admin Successfully');
            return Response::json([
                'status' => 200,
            ]);
        } else {
            return redirect('dashboard');
        }
    }
}
