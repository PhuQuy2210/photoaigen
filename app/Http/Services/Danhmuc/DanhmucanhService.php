<?php

namespace App\Http\Services\Danhmuc;

use App\Models\DanhMucAnh;
use Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class DanhmucanhService
{
    public function getAll()
    {
        return DanhMucAnh::select('*')->get();
    }

    public function show()
    {
        return DanhMucAnh::select('name', 'id')
            ->orderbyDesc('id')
            ->get();
    }

    public function create($request)
    {
        try {
            $data = $request->input();
            $data['name'] = (string)$request->input('name');
            $data['active'] = 1;

            DanhMucAnh::create($data);
            Session::flash('success', 'Tạo Danh Mục Thành Công');
        } catch (Exception $err) {
            Session::flash('error: Thêm danh mục lỗi ', $err->getMessage());
            return false;
        }
        return true;
    }

    public function update($request, $danhmuc): bool
    {
        try {
            $danhmuc->name = (string)$request->input('name');
            $danhmuc->active = $request->input('active');
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
        $danhmuc = DanhMucAnh::find($request->input('id'));

        if ($danhmuc) {
            $danhmuc->delete();
            return true;
        }

        return false;
    }
}
