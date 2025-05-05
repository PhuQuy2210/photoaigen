<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Danhmuc\DanhmucanhService;
use App\Models\DanhMucAnh;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DanhmucanhController extends Controller
{
    protected $danhmucservice;

    public function __construct(DanhmucanhService $danhmucservice)
    {
        $this->danhmucservice = $danhmucservice;
    }

    public function index()
    {
        return view('admin.danhmuc_anh.list', [
            'title' => 'Danh Sách Danh Mục Mới Nhất',
            'danhmucanh' => $this->danhmucservice->getAll()
        ]);
    }

    public function create()
    {
        return view('admin.danhmuc_anh.add', [
            'title' => 'Thêm Danh Mục Mới',
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        $this->danhmucservice->create($request);

        return redirect()->route('menus.list');
    }

    public function show(DanhMucAnh $danhmuc)
    {
        return view('admin.danhmuc_anh.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $danhmuc->name,
            'danhmuc' => $danhmuc,
        ]);
    }

    //CreateFormRequest cung cấp các khả năng bắt lỗi tự động 
    public function update(DanhMucAnh $danhmuc, CreateFormRequest $request)
    {
        $this->danhmucservice->update($request, $danhmuc);

        return redirect('/admin/danhmucanh/list');
    }

    public function destroy(Request $request)
    {
        $result = $this->danhmucservice->delete($request);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa danh mục thành công.'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }
}
