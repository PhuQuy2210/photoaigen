<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Services\User\UserService;
use PhpParser\Node\Stmt\TryCatch;
use App\Models\User;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Chuyển hướng đến trang hiển thị thông tin tài khoản
    public function list()
    {
        return view('admin.users.list', [
            'title' => "Danh sách tài khoản",
            'users' => $this->userService->getAll(),
        ]);
    }

    //Nâng quyền
    public function upgradeRole($id)
    {
        $result = $this->userService->upgradeRole($id);
        return redirect()->back();
    }

    //Hạ quyền
    public function downgradeRole($id)
    {
        $result = $this->userService->downgradeRole($id);
        return redirect()->back();
    }

    //Khóa tài khoản
    public function lockAccount($id)
    {
        $result = $this->userService->lockAccount($id);
        return redirect()->back();
    }

    //Mở khóa tài khoản
    public function unlockAccount($id)
    {
        $result = $this->userService->unlockAccount($id);
        return redirect()->back();
    }

    // Xóa tài khoản 
    public function destroy(Request $request)
    {
        $result = $this->userService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Xóa người dùng thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }

    // Thêm tài khoản
    public function create()
    {
        return view('admin.users.add', [
            'title' => "Thêm tài khoản",
        ]);
    }

    #Xử lý thêm tài
    public function store(Request $request)
    {
        // Validation dữ liệu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:2',
        ]);

        $result = $this->userService->store($request);
        if ($result) {
            return redirect()->route('users.list');
        }
        return redirect()->back();
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        if ($user === null) {
            return redirect()->back()->with('error', 'Tài khoản không tồn tại');
        }

        return view('admin.users.update', [
            'title' => "Cập nhật tài khoản",
            'user' => $user,
            'roles' => $this->userService->getRoles()
        ]);
    }

    public function update($id, UserRequest $request)
    {
        $user = User::findOrFail($id);
        $result = $this->userService->update($user, $request);
        if ($result) {
            return redirect('admin\users\list');
        }
        return redirect()->back();
    }
}
