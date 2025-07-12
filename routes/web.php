<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Client\NewsController as ClientNewsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\UserAccountController as ClientUserAccountController;
use App\Http\Controllers\Client\ProductController as ClientProductController;


Route::get('/', [ClientProductController::class, 'index'])->name('home');

// Route xem sản phẩm và tìm kiếm (không yêu cầu đăng nhập)
Route::get('/shop', [ClientProductController::class, 'shop'])->name('shop');
Route::get('/search', [ClientProductController::class, 'search'])->name('search');
Route::get('/products/{product}', [ClientProductController::class, 'show'])->name('products.show');

// Bài viết
Route::get('/tin-tuc', [ClientNewsController::class, 'index'])->name('news.index');
Route::get('/tin-tuc/{slug}', [ClientNewsController::class, 'show'])->name('news.show');

// đăng ký , đăng nhập
Route::get('login',     [AuthController::class, 'showLoginForm'])->name('login.form');
Route::get('register',  [AuthController::class, 'showFormRegister'])->name('register.form');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login',    [AuthController::class, 'login'])->name('login');
Route::post('logout',   [AuthController::class, 'logout'])->name('logout');

// chat-bot
Route::get('/chat-bot', function (){
    return view('client.chat-bot.index');
})->name('chat-bot');




Route::middleware(['auth'])->group(function () {
    // Trang dashboard của client
    Route::get('/list', function () {
        return view('client.list');
    })->name('client.dashboard');

    // Giỏ hàng
    Route::prefix('cart')
        ->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('cart.index');
            Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
            Route::put('/update/{cart}', [CartController::class, 'update'])->name('cart.update');
            Route::delete('/remove/{cart}', [CartController::class, 'destroy'])->name('cart.remove');
        });

    // Thanh toán
    Route::prefix('checkout')->group(function () {
        Route::get('/', [CheckoutController::class, 'show'])->name('checkout');
        Route::post('/', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    });

    // Xác nhận đơn hàng
    Route::get('/order/confirmation/{order}', [CheckoutController::class, 'confirmation'])
        ->name('order.confirmation');
    Route::get('/orders', [ClientOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [ClientOrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/confirm', [ClientOrderController::class, 'confirm'])->name('orders.confirm');
    Route::post('/orders/{order}/cancel', [ClientOrderController::class, 'cancel'])->name('orders.cancel');

    // // Hiển thị trang quản lý tài khoản
    // Route::get('/my-account', [ClientUserAccountController::class, 'show'])->name('user.account');

    // // Cập nhật thông tin cá nhân
    // Route::post('/my-account/update-info', [ClientUserAccountController::class, 'updateInfo'])->name('user.update-info');

    // // Cập nhật avatar
    // Route::post('/my-account/update-avatar', [ClientUserAccountController::class, 'updateAvatar'])->name('user.update-avatar');

    // // Đổi mật khẩu
    // Route::post('/my-account/change-password', [ClientUserAccountController::class, 'changePassword'])->name('user.change-password');
    // bình luận
    Route::post('/products/{product}/comments', [ClientProductController::class, 'storeComment'])->name('products.comments.store');
});




// Quản lý admin

Route::middleware('auth', 'admin')->prefix('/admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        return view('admin.dashBoard');
    })->name('dashBoard');
    // Quản lý danh mục
    Route::resource('categories', CategoryController::class);
    // Quản lý sản phẩm
    Route::resource('products', ProductController::class);
    // Quản lý slide
    Route::resource('slides', SlideController::class);
    // Quản lý tin tức
    Route::resource('news', NewsController::class);
    // Quản lý người dùng
    Route::prefix('/users')->name('users.')->group(function () {
        Route::get('/',             [UserController::class, 'index'])->name('index');
        Route::get('/{user}',       [UserController::class, 'show'])->name('show');
        Route::put('/{user}/lock',  [UserController::class, 'lock'])->name('lock');
    });
    // Quản lý bình luận
    Route::prefix('/comments')->name('comments.')->group(function () {
        Route::get('/',                         [CommentController::class, 'index'])->name('index');
        Route::put('/{comment}/toggle-status',  [CommentController::class, 'toggleStatus'])->name('toggle-status');
        Route::delete('/{comment}',             [CommentController::class, 'destroy'])->name('destroy');
    });

    // Quản lý đơn hàng
    Route::prefix('/orders')->name('orders.')->group(function () {
        Route::get('/',                 [OrderController::class, 'index'])->name('index');
        Route::get('/{order}',          [OrderController::class, 'show'])->name('show');
        Route::put('/{order}/status',   [OrderController::class, 'updateStatus'])->name('update-status');
        Route::delete('/{order}',       [OrderController::class, 'destroy'])->name('destroy');
    });
});
