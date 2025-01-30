<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.login');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $input = $request->all();

        if (Auth::attempt(['name' => $input['username'], 'password' => $input['password']])) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('signin.show')->with('error', 'Invalid Signin Credentials');
        }
    }
}
