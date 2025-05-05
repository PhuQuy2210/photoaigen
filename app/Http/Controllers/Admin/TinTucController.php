<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Services\TinTuc\TinTucService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Tintuc\TinTucRequest;
use App\Models\TinTuc;
use Illuminate\Foundation\Http\FormRequest;
use Request as GlobalRequest;

class TinTucController extends Controller
{
    protected $blogservice;

    public function __construct(TinTucService $blogservice)
    {
        $this->blogservice = $blogservice;
    }

    // danh sách tin tức
    public function index()
    {
        return view('admin.tintuc.list', [
            'title' => 'Danh Sách Tin Tức',
            'lists' => $this->blogservice->getAll(),
        ]);
    }

    // Phương thức lấy danh sách danh mục và người dùng
    public function create()
    {
        \Log::info('thực hiện thêm tin mục create    controller');

        return view('admin.tintuc.add', [
            'title' => 'Thêm Bản Tin Mới',
            'danhmuctin' => $this->blogservice->getAll_active(),  // Lấy danh mục cha đang hoạt động
            'users' => $this->blogservice->getAll_users(),
        ]);
    }

    //Xử lý thêm tin tức
    public function store(Request $request)
    {
        $result = $this->blogservice->insert($request);
        if ($result) {
            return redirect('admin/tintuc/list');
        }
        return redirect()->back();
    }

    // Kích hoạt
    public function enable(Request $request)
    {
        $result = $this->blogservice->enable($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Kích hoạt thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }

    // Vô hiệu hóa
    public function disable(Request $request)
    {
        $result = $this->blogservice->disable($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Vô hiệu hóa thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }

    public function show(TinTuc $tintuc)
    {
        if ($tintuc === null) {
            return redirect()->back()->with('error', 'Tin không tồn tại');
        }

        return view('admin.tintuc.edit', [
            'title' => "Cập nhật bản tin",
            'tintuc' => $tintuc,
            'danhmuctin' => $this->blogservice->getAll_active(),  // Lấy danh mục cha đang hoạt động
            'users' => $this->blogservice->getAll_users(),
        ]);
    }

    public function update(TinTuc $tintuc, FormRequest $request)
    {
        $result = $this->blogservice->update($tintuc, $request);
        if ($result) {
            return redirect('admin\tintuc\list');
        }
        return redirect()->back();
    }

    // Xóa tin
    public function destroy(Request $request)
    {
        $result = $this->blogservice->delete($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Xóa hình tin thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }
}

