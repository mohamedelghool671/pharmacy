<?php

namespace App\Http\Controllers\pharmacy\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function redirect() {

        if (!Auth::check()) {
            return redirect('login');
        }

        if (Auth::user()->role == "admin") {
            return view('pharmacy.admin.dashboard');
        }

        return view('pharmacy.user.dashboard');
    }

}
