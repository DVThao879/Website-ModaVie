<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\User\AcountController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\user\VerificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ShopController;
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



Route::prefix('user')->as('user.')->group(function(){
   Route::get('/', [ShopController::class,'home'])->name('home');
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
//cua hang
 Route::get('shop',[ShopController::class,'index'])->name('shop');
 //chi tiet san pham
 Route::get('product/detail/{slug}',[ShopController::class,'detail'])->name('product.detail');
 Route::get('/product-variant-price', [ShopController::class, 'getProductVariantPrice'])->name('product.variant.price');
 Route::get('/product/variant/colors', [ShopController::class, 'getColorsBySize'])->name('product.variant.colors');
//tim kiem san pham
Route::get('/search', [ShopController::class, 'search'])->name('product.search');

 //danh muc san pham
 Route::get('shop/categories/{id}',[ShopController::class,'index'])->name('shop.categories');

 //gio hang
 Route::post('cart/add', action: [CartController::class, 'addToCart'])->name('cart.add');
 Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
 Route::post('cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
});
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::prefix('admin')->as('admin.')->group(function(){
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('users', AccountController::class);
});
