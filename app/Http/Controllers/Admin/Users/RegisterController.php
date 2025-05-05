<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Services\User\UserService;


class RegisterController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('admin.users.register', [
            'title' => 'Đăng ký tài khoản'
        ]);
    }

    // Xử lý đăng ký tài khoản
    public function store(Request $request)
    {
        // Validation dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:2',
        ], [
            'name.required' => 'Vui lòng nhập name.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.'
        ]);

        $result = $this->userService->register($request);
        if($result) {
            return redirect('/login');
        }
        return redirect()->back();
    }

    
}
