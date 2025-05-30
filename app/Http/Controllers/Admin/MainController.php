<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BaoCao;
use App\Models\HinhAnh;
use App\Models\SocialAccount;
use App\Models\TinTuc;
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
        $totalUser = User::count();
        $reports = BaoCao::count();
        $totalBlogs = TinTuc::count();
        $totalImages = HinhAnh::count();

        return view('admin.home', compact('title', 'totalUser', 'totalBlogs', 'reports', 'totalImages', 'userDetail'));
    }
}
