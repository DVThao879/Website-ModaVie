<?php

use App\Http\Controllers\User\AcountController;
use App\Http\Controllers\User\ForgotPasswordController;
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
Route::prefix('user')->as('user.')->group(function(){
// khai báo route cho login và register
Route::get('auth/login', [LoginController::class, 'index'])
   ->name('login');
Route::post('auth/login', [LoginController::class, 'login'])
   ->name('login');
Route::post('auth/logout', [LoginController::class, 'logout'])
   ->name('logout');

Route::get('auth/verify/{token}', [LoginController::class, 'verify'])
   ->name('verify');

Route::get('auth/register', [RegisterController::class, 'index'])
   ->name('register');
Route::post('auth/register', [RegisterController::class, 'register'])
   ->name('register');
   
// Đổi mật khẩu
   Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
   Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');
   

//Quên mật khẩu
Route::get('auth/forgot',[ForgotPasswordController::class, 'forgotForm'])->name('forgot');
Route::post('auth/forgot',[ForgotPasswordController::class, 'forgot'])->name('forgot.password');
Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

//Xem thông tin
Route::get('/my_aucount',[AcountController::class,'myAucount'])->name('my_acount');
//Cập nhật tài khoản
Route::post('/my_aucount/update/{id}',[AcountController::class,'updateMyAcount'])->name('updateMyAcount');
//Cập nhật mật khẩu
// Route::post('/my_aucount/password/update/{id}',[AcountController::class,'updatePassword'])->name('updatePassword');

});