<?php

namespace App\Http\Services\Account;

use App\Models\Menu;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


use Exception;
use Illuminate\Testing\Constraints\SeeInOrder;

class AccountService
{
    public function handelChangePass($request, $user)
    {
        //kiểm tra mật khẩu cũ xem có khớp hay không 
        if (!Hash::check($request->input('current_password'), $user->password)) {
            Session::flash('error', 'Mật khẩu cũ nhập không chính sát!!!');
            return false;
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        Session::flash('success', 'Đổi mật khẩu thành công!!!');
        return true;
    }

    public function handelChangeInfo($request, $user)
    {
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->save();
            Session::flash('success', 'Cập nhật thông tin thành công!!!');
            return true;
        } catch (Exception $e) {
            Session::flash('error', 'Cập nhật thông tin không thành công!!!');
            return false;
        }
    }
}
