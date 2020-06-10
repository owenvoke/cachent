<?php

use App\Http\Controllers\Auth;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TorrentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'home')->name('home');

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
});

Route::view('password/reset', 'auth.passwords.email')->name('password.request');
Route::get('password/reset/{token}', Auth\PasswordResetController::class)->name('password.reset');

Route::middleware('auth')->group(function () {
    Route::view('email/verify', 'auth.verify')->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', Auth\EmailVerificationController::class)->middleware('signed')->name('verification.verify');

    Route::post('logout', Auth\LogoutController::class)->name('logout');

    Route::view('password/confirm', 'auth.passwords.confirm')->name('password.confirm');
});
