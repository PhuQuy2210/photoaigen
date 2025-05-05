<?php


namespace App\Http\Services\User;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Role;
use GuzzleHttp\Psr7\Message;
use App\Http\Requests\Account\UserRequest;

class UserService
{
    public function getAll()
    {
        return User::select('*')->paginate(10); // Lấy 10 kết quả trên mỗi trang
    }

    // Nâng quyền
    public function upgradeRole($id)
    {
        $user = User::find($id);

        if ($user && $user->role_id != 0) {
            $user->role_id = $user->role_id - 1;
            $user->save();
            Session::flash('success', 'Nâng quyền thành công!!!');
            return true;
        }
        Session::flash('error', 'Nâng quyền thất bại!!!');
        return false;
    }

    // Hạ quyền 
    public function downgradeRole($id)
    {
        $user = User::find($id);

        if ($user && $user->role_id != 0) {
            $user->role_id = $user->role_id + 1;
            $user->save();
            Session::flash('success', 'Hạ quyền thành công!!!');
            return true;
        }

        Session::flash('error', 'Hạ quyền thất bại');
        return false;
    }

    //Khóa tài khoản
    public function lockAccount($id)
    {
        $user = User::find($id);

        if ($user && $user->is_active == 1) {
            $user->is_active = 0;
            $user->save();
            Session::flash('success', 'Khóa tài khoản thành công!!!');
            return true;
        }
        Session::flash('error', 'Khóa tài khoản thất bại!!!');
        return false;
    }

    //Mở Khóa tài khoản
    public function unlockAccount($id)
    {
        $user = User::find($id);

        if ($user && $user->is_active == 0) {
            $user->is_active = 1;
            $user->save();
            Session::flash('success', 'Mở khóa tài khoản thành công!!!');
            return true;
        }
        Session::flash('error', 'Mở khóa tài khoản thất bại!!!');
        return false;
    }

    // Xóa tài khoản
    public function delete($request)
    {
        $user = User::find($request->input('id'));

        if ($user) {
            $user->delete();
            return true;
        }

        return false;
    }

    // Xử lý thêm tài khoản 
    public function store($request)
    {
        try {
            $data = $request->input();
            $data['role_id'] = 2;  // Quyền mặc định là user
            $data['is_active'] = 1;   // Mặc định là chưa khóa
            $data['password'] = bcrypt($data['password']); //mã hóa 

            User::create($data);
            Session::flash('success', 'Thêm tài khoản mới thành công');
            return true;
        } catch (Exception $e) {

            Session::flash('error', 'Thêm tài khoản lỗi: ' . $e->getMessage());
            return false;
        }
    }

    //Xử lý đăng ký tài khoản
    public function register($request)
    {
        try {
            $data = $request->input();
            $data['role_id'] = 2;  // Quyền mặc định là 2
            $data['is_active'] = 1;   // Mặc định là chưa khóa
            $data['password'] = bcrypt($data['password']); //mã hóa kiểu bcrypt

            User::create($data);
            Session::flash('success', 'Thêm tài khoản mới thành công');
            return true;
        } catch (Exception $e) {
            Session::flash('error', 'Thêm tài khoản lỗi: ' . $e->getMessage());
            return false;
        }
    }

    // Get roles
    public function getRoles()
    {
        return Role::select('*')->get();
    }

    public function update($user, $request)
    {
        try {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->is_active = $request->input('active');
            $user->role_id = $request->input('role_id');

            $user->save();

            Session::flash('success', 'Cập nhật người dùng thành công!');
            return true;
        } catch (Exception $e) {
            Session::flash('error', 'Cập nhật người dùng không thành công!');
            return false;
        }
    }
}
