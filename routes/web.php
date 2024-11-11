<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\User\AcountController;
use App\Http\Controllers\User\ForgotPasswordController;
use App\Http\Controllers\User\LoginController;
use App\Http\Controllers\Admin\CheckLoginController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SizeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\Admin\StatisticsController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Ajax\ChangeActiveController;
use App\Http\Controllers\User\ArticleController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\ReviewController;
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

// Route cho login và register 
Route::middleware('guest')->group(function () {
   Route::get('auth/login', [LoginController::class, 'index'])->name('login');
   Route::post('auth/login', [LoginController::class, 'login']);

   Route::get('auth/register', [RegisterController::class, 'index'])->name('register');
   Route::post('auth/register', [RegisterController::class, 'register']);

   Route::get('auth/forgot', [ForgotPasswordController::class, 'forgotForm'])->name('forgot');
   Route::post('auth/forgot', [ForgotPasswordController::class, 'forgot'])->name('forgot.password');
   Route::get('verify-email/{token}', [ForgotPasswordController::class, 'verifyEmail'])->name('verify.email');

   // Route xác thực email
   Route::get('auth/verify/{token}', [LoginController::class, 'verify'])->name('verify');
});

// Route cho logout 
Route::middleware('auth')->get('auth/logout', [LoginController::class, 'logout'])->name('logout');

// Route đổi mật khẩu 
Route::get('password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ForgotPasswordController::class, 'reset'])->name('password.update');

// Các route tài khoản 
Route::middleware('auth')->group(function () {
   Route::get('/my_acount', [AcountController::class, 'myAucount'])->name('my_acount');
   Route::put('/my_acount/update/{id}', [AcountController::class, 'updateMyAcount'])->name('updateMyAcount');
   Route::get('/my_acount/{id}/bill_detail', [AcountController::class, 'orderBillDetail'])->name('viewBillDetail');
   Route::get('my_acount/orders/cancel/{id}', [HomeController::class, 'cancelOrder'])->name('cancelOrder');
});
// Cửa hàng
Route::get('shop', [ShopController::class, 'index'])->name('shop');
Route::get('product/detail/{slug}', [ShopController::class, 'detail'])->name('product.detail');
Route::get('/product-variant-price', [ShopController::class, 'getProductVariantPrice'])->name('product.variant.price');
Route::get('/product/variant/colors', [ShopController::class, 'getColorsBySize'])->name('product.variant.colors');
// Tìm kiếm sản phẩm 
Route::get('/shop/search-products', [ShopController::class, 'search'])->name('product.search');
// Danh mục sản phẩm 
Route::get('shop/categories/{id}', [ShopController::class, 'index'])->name('shop.categories');
// **Giỏ hàng 
Route::post('cart/add',  [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
Route::post('cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearAllCart'])->name('cart.clear');
// **Thanh toán 
Route::get('/checkout', [CartController::class, 'showCheckout'])->name('checkout');
Route::post('/place-order', [CartController::class, 'placeOrder'])->name('placeOrder');
// Tìm kiếm và theo dõi đơn hàng 
Route::get('/bills/search', [CartController::class, 'searchBill'])->name('bill.search');
Route::get('/my_bill/{id}/bill_detail', [CartController::class, 'orderTracking'])->name('bill.orderTracking');
//Binh luan
Route::post('/comments', [ReviewController::class, 'store'])->name('comments.store');


// Blog 
Route::get('/article', [ArticleController::class, 'index'])->name('article');
Route::get('/article/{id}', [ArticleController::class, 'detail'])->name('article.detail');

//Ap vourcher
Route::post('/apply-voucher', [CartController::class, 'applyVoucher'])->name('apply.voucher');

//Phần Admin

Route::middleware('guest')->group(function () {
   Route::get('admin/login', [CheckLoginController::class, 'loginForm'])->name('admin.loginForm');
   Route::post('admin/checkLogin', [CheckLoginController::class, 'login'])->name('admin.checkLogin');
});
// ->middleware(['auth', 'isAdmin'])
Route::prefix('admin')->as('admin.')->middleware('isAdmin')->group(function () {

   Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
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

   // Cập nhật hồ sơ cá nhân
   Route::get('/accounts/profile', [AccountController::class, 'profile'])->name('profile');
   Route::put('/accounts/profile/update', [AccountController::class, 'updateProfile'])->name('profile.update');
   Route::get('/accounts/profile/change-password', [AccountController::class, 'showChangePasswordForm'])->name('profile.showChangePasswordForm');
   Route::put('/accounts/profile/change-password', [AccountController::class, 'changePassword'])->name('profile.changePassword');

   // Đăng xuất admin
   Route::get('logout', [AccountController::class, 'logout'])->name('logout');

   //Quản lý đơn hàng
   Route::get('bill', [BillController::class, 'index'])->name('bill.index');
   Route::get('bill/{bill_id}/bill-detail', [BillController::class, 'detail'])->name('bill.detail');
   Route::get('bill/confirm/{bill_id}', [BillController::class, 'confirmBill'])->name('bill.confirmBill');
   Route::get('bill/ship/{bill_id}', [BillController::class, 'shipBill'])->name('bill.shipBill');
   Route::get('bill/confirm-shipping/{bill_id}', [BillController::class, 'confirmShipping'])->name('bill.confirmShipping');
   Route::get('bill/cancel/{bill_id}', [BillController::class, 'cancelBill'])->name('bill.cancelBill');

   // In hóa đơn
   Route::get('gerenate/{order_code}', [BillController::class, 'gerenatePdf'])->name('gerenate');

   // Thống kê
   Route::get('statistics', [StatisticsController::class, 'index'])->name('statistics.index');
   Route::post('statistics/show', [StatisticsController::class, 'showStatistics'])->name('statistics.show');

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
