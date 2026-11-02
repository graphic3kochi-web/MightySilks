<?php

namespace App\Providers;

use App\Models\Coupon;
use App\Models\Enquiry;
use App\Models\JobApplication;
use App\Models\Order;
use App\Models\Review;
use App\Models\Setting;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::defaultView('admin.partials.pagination');

        // Per visitor (IP) and per kind, so placing an order never eats into the login allowance.
        RateLimiter::for('auth', fn (Request $request) => Limit::perMinute(10)->by('auth|'.$request->ip()));
        RateLimiter::for('forms', fn (Request $request) => Limit::perMinute(30)->by('forms|'.$request->ip()));

        // Storefront pages: the store rules js/main.js reads (window.SHOP) and the cart drawer shows.
        View::composer('layouts.site', function ($view) {
            $coupon = Coupon::featured();
            $user = auth()->user();
            $view->with('shop', [
                'coupon' => $coupon ? ['code' => $coupon->code, 'rate' => $coupon->percent / 100] : null,
                'shipping' => Setting::shipping(),
                'user' => $user ? ['name' => $user->name, 'email' => $user->email, 'phone' => $user->phone] : null,
            ]);
        });

        // Admin sidebar and top bar: what's waiting on the team.
        View::composer('layouts.admin', function ($view) {
            $view->with('pending', [
                'orders' => Order::where('status', 'placed')->count(),
                'reviews' => Review::where('status', 'pending')->count(),
                'enquiries' => Enquiry::where('status', 'new')->count(),
                'applications' => JobApplication::where('status', 'new')->count(),
            ]);
        });
    }
}
