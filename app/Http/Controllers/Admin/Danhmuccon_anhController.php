<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Danhmuc\Danhmuccon_anhService;
use App\Models\DanhMucAnh;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\CatagoryImgChild;

class Danhmuccon_anhController extends Controller
{
    protected $danhmucservice;

    public function __construct(Danhmuccon_anhService $danhmucservice)
    {
        $this->danhmucservice = $danhmucservice;
    }

    public function index()
    {
        return view('admin.danhmuc_con_anh.list', [
            'title' => 'Danh Sách Danh Mục',
            'danhmuccon_anh' => $this->danhmucservice->getCategory(),
            // 'danhmucanh' => $this->danhmucservice->getAll(),
        ]);
    }

    public function create()
    {
        return view('admin.danhmuc_con_anh.add', [
            'title' => 'Thêm Danh Mục Con Mới',
            'danhmucanh' => $this->danhmucservice->getAll(),
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        $result = $this->danhmucservice->create($request);
        if($result) {
            return redirect('admin/danhmuccon_anh/list');
        }
        return redirect()->back();
    }

    public function show(CatagoryImgChild $danhmuc)
    {
        return view('admin.danhmuc_con_anh.edit', [
            'title' => 'Chỉnh Sửa Danh Mục: ' . $danhmuc->name,
            'danhmuc' => $danhmuc,
            'danhmuc_cha' => $this->danhmucservice->getAll(),
        ]);
    }

    //CreateFormRequest cung cấp các khả năng bắt lỗi tự động 
    public function update(CatagoryImgChild $danhmuc, CreateFormRequest $request)
    {
        $this->danhmucservice->update($request, $danhmuc);

        return redirect('/admin/danhmuccon_anh/list');
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
