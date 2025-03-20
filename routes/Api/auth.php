<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Api\AuthController;

Route::controller(AuthController::class)->group(function() {

        Route::post("register","register");
        Route::post("login","login");
        Route::post("logout","logout")->middleware('auth:sanctum');
        Route::post("login/{provider}/callback","socialLogin");
        Route::post("forget-password","forgetPassword");
        Route::post("reset-password","resetPassword");
});


