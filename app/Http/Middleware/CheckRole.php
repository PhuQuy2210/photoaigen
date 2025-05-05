<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Kiểm tra nếu user không phải admin
        if (!$user || $user->role_id !== 0) {
            abort(403, 'Bạn không có quyền truy cập.');
        }

        return $next($request);
    }
}
