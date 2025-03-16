<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\pharmacy\LoginController;
use App\Http\Controllers\pharmacy\auth\AuthController;

Route::get('/redirect',[AuthController::class,'redirect'])->name('redirect');
Route::get("/",function() {
    return view("pharmacy.home");
})->name('home');

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



// socialite routes



Route::get('login/google', [LoginController::class, 'redirectGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'redirectGoogleCallback']);

Route::get('login/facebook', [LoginController::class, 'redirectFacebook'])->name('login.facebook');
Route::get('login/facebook/callback', [LoginController::class, 'redirectFacebookCallback']);


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
