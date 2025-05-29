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
use Storage;

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

    public function delete_img($request)
    {
        try {
            $id = $request->input('idimg');

            // Xóa các bản ghi liên quan
            UserLike::where('hinhanh_id', $id)->delete();
            BaoCao::where('hinhanh_id', $id)->delete();

            // Xóa hình ảnh
            $image = HinhAnh::find($id);
            if (!$image) return false;

            Storage::disk('s3')->delete([$image->url, $image->thumb_path]);
            $image->delete();

            return true;
        } catch (Exception $e) {
            \Log::error('Lỗi khi xóa hình ảnh báo cáo', ['message' => $e->getMessage()]);
            return false;
        }
    }

    public function get_user($userID)
    {
        return User::findOrFail('id', $userID);
    }
}
