<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\User\AcountController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Ajax\ChangeActiveController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\HomeController;
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


Route::get('/', [HomeController::class, 'home'])->name('home');
// Khai báo route cho login và register
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

// Đổi mật khẩu
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

//Quên mật khẩu
Route::get('auth/forgot', [ForgotPasswordController::class, 'forgotForm'])->name('forgot');
Route::post('auth/forgot', [ForgotPasswordController::class, 'forgot'])->name('forgot.password');
Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

//Xem thông tin
Route::get('/my_acount', [AcountController::class, 'myAucount'])->name('my_acount');
//Cập nhật tài khoản
Route::post('/my_acount/update/{id}', [AcountController::class, 'updateMyAcount'])->name('updateMyAcount');
//Chi tiết bill
Route::get('/my_acount/{id}/bill_detail', [AcountController::class, 'orderBillDetail'])->name('viewBillDetail');
// Cửa hàng
Route::get('shop', [ShopController::class, 'index'])->name('shop');
// Chi tiết sản phẩm
Route::get('product/detail/{slug}', [ShopController::class, 'detail'])->name('product.detail');
Route::get('/product-variant-price', [ShopController::class, 'getProductVariantPrice'])->name('product.variant.price');
Route::get('/product/variant/colors', [ShopController::class, 'getColorsBySize'])->name('product.variant.colors');
// Tìm kiếm sản phẩm
Route::get('/search', [ShopController::class, 'search'])->name('product.search');

// Danh mục sản phẩm
Route::get('shop/categories/{id}', [ShopController::class, 'index'])->name('shop.categories');

// Giỏ hàng
Route::post('cart/add', action: [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Thanh toán
Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout');
Route::post('/place-order', [CartController::class, 'placeOrder'])->name('placeOrder');

// Tìm kiếm đơn hàng
Route::get('/bills/search', [CartController::class, 'searchBill'])->name('bill.search');
Route::get('/my_bill/{id}/bill_detail', [CartController::class, 'orderTracking'])->name('bill.orderTracking');

//Phần Admin
Route::prefix('admin')->as('admin.')->group(function () {
   Route::get('/', function () {
      return view('admin.dashboard');
   })->name('dashboard');
   Route::resource('categories', CategoryController::class);
   Route::resource('products', ProductController::class);
   Route::resource('colors', ColorController::class);
   Route::resource('sizes', SizeController::class);
   Route::resource('banners', BannerController::class);
   Route::resource('vouchers', VoucherController::class);
   Route::resource('blogs', BlogController::class);

   Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
   Route::get('/comments/{id}', [CommentController::class, 'show'])->name('comments.show');

   Route::get('/users/listUser', [AccountController::class, 'listUser'])->name('users.listUser');
   Route::resource('users', AccountController::class);

   //ajax category
   Route::post('categories/ajax/changeActiveCategory', [ChangeActiveController::class, 'changeActiveCategory']);
   Route::post('categories/ajax/changeAllActiveCategory', [ChangeActiveController::class, 'changeActiveAllCategory']);
   //ajax banner
   Route::post('banners/ajax/changeActiveBanner', [ChangeActiveController::class, 'changeActiveBanner']);
   Route::post('banners/ajax/changeAllActiveBanner', [ChangeActiveController::class, 'changeActiveAllBanner']);
   //ajax account
   Route::post('accounts/ajax/changeActiveAccount', [ChangeActiveController::class, 'changeActiveAccount']);
   Route::post('accounts/ajax/changeAllActiveAccount', [ChangeActiveController::class, 'changeActiveAllAccount']);
   Route::post('users/accounts/ajax/changeActiveAccount', [ChangeActiveController::class, 'changeActiveAccount']);
   Route::post('users/accounts/ajax/changeAllActiveAccount', [ChangeActiveController::class, 'changeActiveAllAccount']);
   //ajax product
   Route::post('products/ajax/changeActiveProduct', [ChangeActiveController::class, 'changeActiveProduct']);
   Route::post('products/ajax/changeAllActiveProduct', [ChangeActiveController::class, 'changeActiveAllProduct']);
   //ajax blog
   Route::post('blogs/ajax/changeActiveBlog', [ChangeActiveController::class, 'changeActiveBlog']);
   Route::post('blogs/ajax/changeAllActiveBlog', [ChangeActiveController::class, 'changeActiveAllBlog']);
   //ajax blog
   Route::post('vouchers/ajax/changeActiveVoucher', [ChangeActiveController::class, 'changeActiveVoucher']);
   Route::post('vouchers/ajax/changeAllActiveVoucher', [ChangeActiveController::class, 'changeActiveAllVoucher']);
   //ajax comment
   Route::post('comments/comments/ajax/changeActiveComment', [ChangeActiveController::class, 'changeActiveComment']);
   Route::post('comments/comments/ajax/changeAllActiveComment', [ChangeActiveController::class, 'changeActiveAllComment']);
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
   \UniSharp\LaravelFilemanager\Lfm::routes();
});
