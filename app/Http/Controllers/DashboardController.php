<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
}
