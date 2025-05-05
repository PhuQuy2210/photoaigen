<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Danhmuc\DanhmuctinService;
use App\Models\DanhMucTin;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DanhmuctinController extends Controller
{
    protected $danhmucservice;

    public function __construct(DanhmuctinService $danhmucservice)
    {
        $this->danhmucservice = $danhmucservice;
    }

    public function index()
    {
        return view('admin.danhmuc_tin.list', [
            'title' => 'Danh Sách Danh Mục Mới Nhất',
            'danhmuctin' => $this->danhmucservice->getAll()
        ]);
    }

    public function create()
    {
        return view('admin.danhmuc_tin.add', [
            'title' => 'Thêm Danh Mục Mới',
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        $this->danhmucservice->create($request);

        return redirect('admin/danhmuctin/list');
    }

    public function show(DanhMucTin $danhmuc)
    {
        return view('admin.danhmuc_tin.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $danhmuc->name,
            'danhmuc' => $danhmuc,
        ]);
    }

    //CreateFormRequest cung cấp các khả năng bắt lỗi tự động 
    public function update(DanhMucTin $danhmuc, CreateFormRequest $request)
    {
        $this->danhmucservice->update($request, $danhmuc);

        return redirect('/admin/danhmuctin/list');
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
