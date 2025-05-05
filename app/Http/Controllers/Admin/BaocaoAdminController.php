<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\BaoCao\BaoCaoAdminService;
use App\Models\BaoCao;
use App\Models\DanhMucTin;
use App\Models\HinhAnh;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class BaocaoAdminController extends Controller
{
    protected $baocaoservice;

    public function __construct(BaoCaoAdminService $baocaoservice)
    {
        $this->baocaoservice = $baocaoservice;
    }

    public function index()
    {
        return view('admin.baocao.list', [
            'title' => 'Danh Sách Report',
            'lists' => $this->baocaoservice->getAll(),
            'countKiemDuyet' => BaoCao::where('kiemduyet', 0)->count(),
        ]);
    }

    // Kích hoạt
    public function enable(Request $request)
    {
        $result = $this->baocaoservice->enable($request);
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
        $result = $this->baocaoservice->disable($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Vô hiệu hóa thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }

    public function destroy(Request $request)
    {
        $result = $this->baocaoservice->delete($request);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa báo cáo thành công.'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    // xóa ảnh vi phạm 
    public function destroy_img(Request $request)
    {
        $result = $this->baocaoservice->delete_img($request);

        if ($result) {
            return response()->json([
                'error' => false,
                'message' => 'Xóa ảnh thành công.'
            ]);
        }

        return response()->json([
            'error' => true
        ]);
    }

    // chuyển hướng đến trang báo cáo 
    public function report($id)
    {
        $baocao = BaoCao::with('hinhanh')->findOrFail($id);
        $userID = $baocao->user_id;

        $user = User::where('id', $userID)->first();
        
        $img = HinhAnh::where('id', $baocao->hinhanh_id)->first();

        return view('admin.baocao.report', [
            'title' => '',
            'baocao' => $baocao,
            'user' => $user,
            'image' => $img
        ]);
    }

    // Thêm nút kiểm duyệt và xóa hình ảnh
    // public function baocao_Store(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'sdt' => 'required|numeric',
    //         'quocgia' => 'required|string',
    //         'url' => 'required|url',
    //         'description' => 'required|string',
    //     ]);

    //     $result = $this->baocaoservice->insert($request);

    //     if ($result) {
    //         return redirect('/');
    //     }
    //     return redirect()->back();
    // }
}
