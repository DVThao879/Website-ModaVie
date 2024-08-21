<?php

use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\user\VerificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('client.home');
});

// khai báo route cho login và register
Route::get('auth/login', [LoginController::class, 'index'])
   ->name('login');
Route::post('auth/login', [LoginController::class, 'login'])
   ->name('login');
Route::get('auth/logout', [LoginController::class, 'logout'])
   ->name('logout');
Route::get('auth/verify/{token}', [LoginController::class, 'verify'])
   ->name('verify');

Route::get('auth/register', [RegisterController::class, 'index'])
   ->name('register');
Route::post('auth/register', [RegisterController::class, 'register'])
   ->name('register');
