<?php

namespace App\Http\Controllers;

use App\Http\Services\BaoCao\BaoCaoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class BaocaoController extends Controller
{
    protected $baocaoService;

    public function __construct(BaoCaoService $baocaoService)
    {
        $this->baocaoService = $baocaoService;
    }

    // chuyển hướng đến trang báo cáo 
    public function report($idimg)
    {
        if (!Auth::check()) {
            return redirect('/admin/users/login');
        }

        return view('baocao.report', [
            'title' => 'Ảnh theo danh mục con',
            'image' => $this->baocaoService->getImg($idimg)
        ]);
    }

    public function checkLogin(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['success' => false, 'message' => 'Bạn chưa đăng nhập. Bạn có muốn chuyển đến trang đăng nhập không!!!'], 401);
            }

        } catch (\Exception $e) {
            \Log::error("Lỗi khi thực hiện like: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi!'], 500);
        }
    }


    //xử lý gửi báo cáo
    public function baocao_Store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'sdt' => 'required|numeric',
            'quocgia' => 'required|string',
            'url' => 'required|url',
            'description' => 'required|string',
        ]);

        $result = $this->baocaoService->insert($request);

        if ($result) {
            return redirect('/');
        }
        return redirect()->back();
    }
}
