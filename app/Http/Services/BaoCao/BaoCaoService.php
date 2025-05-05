<?php

namespace App\Http\Services\BaoCao;

use App\Models\BaoCao;
use App\Models\HinhAnh;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucAnh;
use Exception;
use Illuminate\Support\Facades\Auth;

class BaoCaoService
{
    //Lấy danh sách ảnh
    public function getAll()
    {
        return HinhAnh::select('*')->paginate(10);
    }

    //lấy danh sách danh mục
    public function getDanhMucAnh()
    {
        return DanhMucAnh::where('active', 1)->get();
    }

    //Lấy ảnh theo ID
    public function getImg($id)
    {
        return HinhAnh::where('id', $id)
            ->where('active', 1)
            ->first();
    }

    public function insert($request)
    {
        try {
            $data = [
                'user_id' => Auth::id(), // Lấy ID của người dùng hiện tại
                'hinhanh_id' => $request->input('hinhanh_id'), // ID của hình ảnh vi phạm
                'email' => $request->input('email'),
                'sdt' => $request->input('sdt'),
                'quocgia' => $request->input('quocgia'),
                'url' => $request->input('url'),
                'kiemduyet' => "0",
                'description' => $request->input('description'),
            ];
            // Lưu thông tin báo cáo vào cơ sở dữ liệu
            BaoCao::create($data);
            // Thêm thông báo thành công
            Session::flash('success', __('messages.report_sent_success'));

            return true;
        } catch (Exception $e) {
            // Xử lý lỗi nếu có
            Session::flash('error', __('messages.report_sent_error') . ': ' . $e->getMessage());
            return false;
        }
    }
}
