<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialAccount;

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
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $userID = Auth::id();
                $userDetail = SocialAccount::where('user_id', $userID)->first();
                $view->with('userDetail', $userDetail);
            } else {
                $view->with('userDetail', null);
            }
        });
    }
}
