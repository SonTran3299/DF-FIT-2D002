<?php

namespace App\Providers;

use App\Models\Contact;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AdminViewServiceProvider extends ServiceProvider
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
        View::composer('admin.*', function ($view) {
            $view->with('messages', Contact::orderBy('status', 'asc')->orderBy('updated_at', 'desc')->with('user')->take(5)->get());
            $view->with('messageCount', Contact::where('status', '0')->count());
            $view->with('categoryList', ProductCategory::orderBy('name', 'asc')->where('status', '1')->get());
        });
    }
}
