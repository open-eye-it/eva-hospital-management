<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->user = new User;
    }

    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function signout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
        return redirect()->route('signin.show');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function change_password(Request $request)
    {
        $input = $request->all();
        $user = Auth::user();
        if (Hash::check($input['old_password'], $user->password)) {
            $pass = Hash::make($input['password']);
            $update = $this->user->updateUser(['password' => $pass], $user->user_id);
            if ($update == 1) {
                return redirect()->route('profile')->with('success', 'Password changed');
            } else {
                return redirect()->route('profile')->with('error', 'Password not changed, please try again');
            }
            //updateUser
        } else {
            return redirect()->route('profile')->with('error', 'Current password not matched');
        }
    }
}
