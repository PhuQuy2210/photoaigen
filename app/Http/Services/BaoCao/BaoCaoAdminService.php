<?php

namespace App\Http\Services\BaoCao;

use App\Models\BaoCao;
use App\Models\HinhAnh;
use App\Models\UserLike;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucAnh;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class BaoCaoAdminService
{
    //Lấy danh sách ảnh
    public function getAll()
    {
        return BaoCao::with('hinhanh')->select('*')->paginate(10);
    }

    public function enable($request)
    {
        $result = BaoCao::where('id', $request->input('id'))->first();
        if ($result) {
            $result->kiemduyet = 1; // Kích hoạt
            $result->save();
            return true;
        }
        return false;
    }

    public function disable($request)
    {
        $result = BaoCao::where('id', $request->input('id'))->first();
        if ($result) {
            $result->kiemduyet = 0; // Vô hiệu hóa
            $result->save();
            return true;
        }
        return false;
    }

    public function delete($request)
    {
        $baocao = BaoCao::find($request->input('id'));

        if ($baocao) {
            $baocao->delete();
            return true;
        }

        return false;
    }

    // xử lý xóa ảnh
    public function delete_img($request)
    {
        try {
            // Xóa các bản ghi liên quan trong bảng user_likes
            UserLike::where('hinhanh_id', $request->input('idimg'))->delete();

            // Xóa các báo cáo liên quan đến hình ảnh
            BaoCao::where('hinhanh_id', $request->input('idimg'))->delete();

            // Xóa hình ảnh
            $image = HinhAnh::find($request->input('idimg'));
            if ($image) {
                $image->delete();
                return true;
            }

            return false;
        } catch (Exception $e) {
            \Log::error('Lỗi khi xóa hình ảnh:', ['error' => $e->getMessage()]);
            return false;
        }
    }

    public function get_user($userID)
    {
        return User::findOrFail('id', $userID);
    }

}
