<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    public function handle(Request $request, Closure $next)
    {
        $locale = Session::get('locale', config('app.locale')); // Mặc định là ngôn ngữ của config
        App::setLocale($locale);  // Đặt ngôn ngữ cho ứng dụng
        return $next($request);
    }
}

