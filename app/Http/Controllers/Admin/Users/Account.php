<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\AccountRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Services\Account\AccountService;
use App\Models\SocialAccount;
use App\Models\User;
use App\Models\UserLike;

class Account extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    // Chuyển hướng đến trang hiển thị thông tin tài khoản
    public function getInfo()
    {
        $userID = Auth::user()->id;

        // Thông tin người dùng đăng nhập bằng Google (nếu có)
        $userDetail = SocialAccount::where('user_id', $userID)->first();

        // Đếm số lượng ảnh đã like
        $likedCount = UserLike::where('user_id', $userID)->count();
        \Log::info('user'.$userDetail);
        return view('admin.account.getInfo', [
            'title' => "Thông tin tài khoản",
            'userDetail' => $userDetail,
            'likedCount' => $likedCount,
        ]);
    }

    public function changePass()
    {
        // $user = Auth::user();  //lấy ra thông tin tài khoản đang đăng nhập
        return view('admin.account.changePass', [
            'title' => "Thay đổi mật khẩu",
        ]);
    }


    public function handelChangePass(AccountRequest $request)
    {
        $user = Auth::user();  //lấy ra thông tin tài khoản đang đăng nhập
        $result = $this->accountService->handelChangePass($request, $user);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect('/admin/account/info');
    }


    //trang người dùng
    public function getInfo_user()
    {
        $userID = Auth::user()->id;

        // Thông tin người dùng đăng nhập bằng Google (nếu có)
        $userDetail = SocialAccount::where('user_id', $userID)->first();

        // Đếm số lượng ảnh đã like
        $likedCount = UserLike::where('user_id', $userID)->count();

        return view('admin.account-user.getInfo', [
            'title' => "Thông tin tài khoản",
            'userDetail' => $userDetail,
            'likedCount' => $likedCount,
        ]);
    }

    public function changePass_user()
    {
        // $user = Auth::user();  //lấy ra thông tin tài khoản đang đăng nhập
        return view('admin.account-user.changePass', [
            'title' => "Thay đổi mật khẩu",
        ]);
    }


    public function handelChangePass_user(AccountRequest $request)
    {
        $user = Auth::user();  //lấy ra thông tin tài khoản đang đăng nhập
        $result = $this->accountService->handelChangePass($request, $user);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect('/account-user/info-user');
    }

    public function changeInfo_user()
    {
        $user = Auth::user();
        return view('admin.account-user.changeInfo', [
            'title' => "Cập nhật thông tin",
            'user' => $user,
        ]);
    }



    public function handelChangeInfo_user(Request $request)
    {
        $user = Auth::user();
        $result = $this->accountService->handelChangeInfo($request, $user);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect('/account-user/info-user');
    }

    public function changeInfo_admin()
    {
        $user = Auth::user();
        return view('admin.account.changeInfo', [
            'title' => "Cập nhật thông tin",
            'user' => $user,
        ]);
    }
    public function handelChangeInfo_admin(Request $request)
    {
        $user = Auth::user();
        $result = $this->accountService->handelChangeInfo($request, $user);
        if ($result === false) {
            return redirect()->back();
        }
        return redirect('/admin/account/info');
    }
}
