<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location; // Cần cài đặt package này nếu muốn tự động nhận diện quốc gia

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Kiểm tra nếu đã có session ngôn ngữ
        if (Session::has('lang')) {
            App::setLocale(Session::get('lang'));
        } else {
            // Nhận diện quốc gia của người dùng bằng IP (cần cài package stevebauman/location)
            $position = Location::get($request->ip());

            // Nếu không phải người Việt Nam thì mặc định là tiếng Anh
            if ($position && $position->countryCode !== 'VN') {
                App::setLocale('en');
                Session::put('lang', 'en');
            } else {
                App::setLocale('vi');
                Session::put('lang', 'vi');
            }
        }

        return $next($request);
    }
}
