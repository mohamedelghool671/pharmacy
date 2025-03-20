<?php

namespace App\Http\Controllers\pharmacy;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class LoginController extends Controller
{
    // google methods
    public function redirectGoogle()
{
    return Socialite::driver('google')->redirect();
}

public function redirectGoogleCallback()
{
    $user = Socialite::driver('google')->user();
    dd($user);
    $this->_registerOrLoginUser($user);
    if($user->role == "admin") {
        return view("pharmacy.admin.dashboard");
    }
    return view('pharmacy.user.dashboard');
}

public function redirectFacebook()
{
    return Socialite::driver('facebook')->redirect();
}

public function redirectFacebookCallback()
{
    $user = Socialite::driver('facebook')->user();
    $this->_registerOrLoginUser($user);
    return redirect()->route("home");
}

protected function _registerOrLoginUser($data)
{
    $user = User::where('email', $data->email)->first();

    if (!$user) {
        $user = new User();
        $nameParts = explode(' ', $data->name, 2);
        $user->first_name = $nameParts[0] ?? null;
        $user->last_name = $nameParts[1] ?? null;
        $user->email = $data->email;
        $user->provider_id = $data->id;
        $user->phone = $data->phone ?? null;
        $user->save();
    }

    Auth::login($user);
}



}
