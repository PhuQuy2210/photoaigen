<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaoCao;
use App\Models\HinhAnh;
use App\Models\SocialAccount;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $userID = Auth::user()->id;
        $userDetail = SocialAccount::where('user_id', $userID)->first();

        $title = "Thống kê";

        // Lấy tổng số tài khoản
        $totalUser = User::count();

        // Lấy tổng số người dùng đang online (is_active = 1)
        $reports = BaoCao::count();

        // Lấy tổng số hình ảnh
        $totalImages = HinhAnh::count();

        return view('admin.home', compact('title', 'totalUser', 'reports', 'totalImages', 'userDetail'));
    }
}
