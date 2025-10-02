<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ClientViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('client.*', function ($view) {
            $view->with('categoryList', ProductCategory::orderBy('name', 'asc')->where('status', '1')->get());
            $view->with('cartCount', Cart::where('user_id', Auth::id())->count());
        });
    }
}
