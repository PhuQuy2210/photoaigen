<?php

namespace App\Http\Services\Danhmuc;

use App\Models\DanhMucAnh;
use App\Models\CatagoryImgChild;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class Danhmuccon_anhService
{
    //lấy danh sách danh mục cha
    public function getAll()
    {
        return DanhMucAnh::select('*')->get();
    }

    //Sử dụng with('parent') để tải thông tin danh mục cha khi lấy danh sách danh mục con:
    public function getCategory()
    {
        return CatagoryImgChild::with('parent')->get();
    }

    public function create($request)
    {
        try {
            $data = $request->input();
            $data['name'] = $request->input('name');
            $data['parent_id'] = $request->input('danhmuc_id');
            $data['active'] = 1;
            CatagoryImgChild::create($data);
            Session::flash('success', 'Tạo Danh Mục Thành Công');
            return true;
        } catch (Exception $err) {
            Session::flash('error', 'Thêm danh mục lỗi: ' . $err->getMessage());
            return false;
        }
    }


    public function show()
    {
        return DanhMucAnh::select('name', 'id')
            ->orderbyDesc('id')
            ->get();
    }

    public function update($request, $danhmuc): bool
    {
        try {
            $danhmuc->name = (string)$request->input('name');
            $danhmuc->active = $request->input('active');
            $danhmuc->parent_id = $request->input('danhmuc_id');
            $danhmuc->save();
            Session::flash('success', 'Cập nhật thành công Danh mục');
            return true;
        } catch (Exception $e) {
            Session::flash('error: Cập nhật danh mục lỗi ', $e->getMessage());
            return false;
        }
    }

    public function delete($request)
    {
        $danhmuc = CatagoryImgChild::find($request->input('id'));

        if ($danhmuc) {
            $danhmuc->delete();
            return true;
        }

        return false;
    }
}
