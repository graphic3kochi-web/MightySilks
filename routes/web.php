<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Shop\AccountController;
use App\Http\Controllers\Shop\FormController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

// ---------- Storefront: clean URLs (/about); the pages themselves are registered last ----------
Route::get('/', [SiteController::class, 'page'])->name('home');
Route::get('my-orders', [OrderController::class, 'mine'])->name('my-orders');
Route::get('orders/{number}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');
// The static site's old addresses (about.html, index.html) move permanently, query string and all.
Route::get('{page}.html', [SiteController::class, 'legacy'])->where('page', '[a-z0-9-]+');
// The data scripts the pages load, now generated from the database.
Route::get('js/products.js', [SiteController::class, 'productsScript']);
Route::get('js/blogs.js', [SiteController::class, 'blogsScript']);
Route::get('js/jobs.js', [SiteController::class, 'jobsScript']);

// ---------- Storefront endpoints (js/main.js, js/product.js) ----------
Route::prefix('api')->group(function () {
    Route::middleware('throttle:auth')->group(function () {
        Route::post('register', [AccountController::class, 'register']);
        Route::post('register/verify', [AccountController::class, 'verifyRegistration']);
        Route::post('login', [AccountController::class, 'login']);
        Route::post('login/code', [AccountController::class, 'sendCode']);
        Route::post('login/verify', [AccountController::class, 'verifyCode']);
    });
    Route::middleware('throttle:forms')->group(function () {
        Route::post('orders', [OrderController::class, 'store']);
        Route::post('orders/track', [OrderController::class, 'track']);
        Route::post('orders/{number}/cancel', [OrderController::class, 'cancel']);
        Route::post('subscribe', [FormController::class, 'subscribe']);
        Route::post('enquiries', [FormController::class, 'enquiry']);
        Route::post('contact', [FormController::class, 'contact']);
        Route::post('careers', [FormController::class, 'apply']);
        Route::post('reviews', [FormController::class, 'review']);
    });
    Route::get('orders/{number}', [OrderController::class, 'show']);
});
Route::post('logout', [AccountController::class, 'logout'])->name('logout');

// ---------- Admin panel ----------
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [Admin\AuthController::class, 'show'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:auth');
    Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::resource('products', Admin\ProductController::class)->except('show');
        Route::resource('collections', Admin\CollectionController::class)->only(['index', 'edit', 'update']);
        Route::resource('orders', Admin\OrderController::class)->only(['index', 'show', 'update']);
        Route::get('orders/{order}/invoice', [Admin\OrderController::class, 'invoice'])->name('orders.invoice');
        Route::resource('customers', Admin\CustomerController::class)->only(['index', 'show', 'update']);
        Route::resource('coupons', Admin\CouponController::class)->except('show');
        Route::resource('reviews', Admin\ReviewController::class)->only(['index', 'update', 'destroy']);

        Route::resource('blogs', Admin\BlogController::class)->except('show');
        Route::resource('careers', Admin\CareerController::class)->except('show')->parameters(['careers' => 'career']);
        Route::resource('applications', Admin\ApplicationController::class)->only(['index', 'show', 'update']);
        Route::get('applications/{application}/cv', [Admin\ApplicationController::class, 'cv'])->name('applications.cv');
        Route::resource('enquiries', Admin\EnquiryController::class)->only(['index', 'show', 'update'])->parameters(['enquiries' => 'enquiry']);
        Route::get('subscribers', [Admin\SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('subscribers/export', [Admin\SubscriberController::class, 'export'])->name('subscribers.export');
        Route::delete('subscribers/{subscriber}', [Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');
        Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings.edit');
        Route::put('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    });
});

// ---------- Storefront pages (/about, /bridal…): last, so /admin, /api and the rest match first ----------
// The home page lives at / only, so /index moves there.
Route::permanentRedirect('index', '/');
Route::get('{page}', [SiteController::class, 'page'])->where('page', '[a-z0-9-]+')->name('page');
