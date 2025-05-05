<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use ValidatesRequests; // Bổ sung trait này nếu chưa có

    public function index()
    {
        return view('admin.users.login', [
            'title' => 'Đăng Nhập Hệ Thống'
        ]);
    }

    // xử lý đăng nhập
    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:filter',
            'password' => 'required'
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.'
        ]);

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'))) {

            // Kiểm tra xem tài khoản có bị khóa không
            if (Auth::user()->is_active == 0) {
                Auth::logout(); // Đăng xuất ngay nếu tài khoản bị khóa
                Session::flash('error', 'Tài khoản này đã bị khóa!!!');
                return redirect()->back();
            }
            Session::flash('success', __('messages.success_greeting', ['name' => Auth::user()->name]));

            return redirect('/');
        }

        Session::flash('error', 'Email hoặc Password không đúng');
        return redirect()->back();
    }


    // Xử lý đăng xuất tài khoản
    public function logout(Request $request)
    {
        // Hủy bỏ session và đăng xuất người dùng
        Auth::logout();

        // Xóa session và CSRF token nếu cần thiết
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Đăng xuất thành công');
    }
}
