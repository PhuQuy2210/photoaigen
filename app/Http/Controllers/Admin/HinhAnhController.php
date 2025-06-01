<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\HinhAnh\HinhAnhAdminService;
use App\Http\Requests\Hinhanh\HinhanhRequest;
use App\Models\HinhAnh;
use App\Models\DanhMucAnh;
use App\Models\CatagoryImgChild;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLike;



class HinhAnhController extends Controller
{
    protected $hinhanhAdminService;

    public function __construct(HinhAnhAdminService $hinhanhAdminService)
    {
        $this->hinhanhAdminService = $hinhanhAdminService;
    }

    // danh sách ảnh
    public function index(Request $request)
    {
        $danhmuc = $request->category_id;
        $search = $request->search;

        $danhmucs = DanhMucAnh::where('active', 1)->get();

        $lists = Hinhanh::query();

        if (!empty($danhmuc)) {
            $lists->where('category_id', $danhmuc);
        }

        // Lọc theo từ khóa tìm kiếm không phân biệt chữ hoa và chữ thường
        if (!empty($search)) {
            $lists->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(id) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        }

        $lists = $lists->paginate('10');

        if ($request->ajax()) {
            return view('admin.hinhanh.danhsachanh', compact('lists'))->render();
        }

        return view('admin.hinhanh.list', [
            'title' => 'Danh Sách Hình Ảnh',
            'lists' => $lists,
            'danhMucs' => $danhmucs,
            'category_id' => $danhmuc,
        ]);
    }

    // Phương thức lấy danh sách danh mục và danh mục con
    public function create()
    {
        return view('admin.hinhanh.add', [
            'title' => 'Thêm hình ảnh mới',
            'danhmucanh' => DanhMucAnh::active()->get(),  // Lấy danh mục cha đang hoạt động
            'catagory_img_childs_description' => $this->hinhanhAdminService->getDanhMucMoTa(),
            'catagory_img_childs' => $this->hinhanhAdminService->getDanhMucCon(),

        ]);
    }

    //Xử lý thêm ảnh
    public function store(Request $request)
    {
        $request->validate([
            'url.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:20048',
            'description' => 'nullable|string|max:1000',
            'direction' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:danhmucanh,id',
            'category_child' => 'nullable|integer|exists:catagory_img_child,id',
        ]);
        
        $result = $this->hinhanhAdminService->insert($request);
        if ($result) {
            return redirect('admin/hinhanh/list');
        }
        return redirect()->back();
    }

    // Kích hoạt
    public function enable(Request $request)
    {
        $result = $this->hinhanhAdminService->enable($request);
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
        $result = $this->hinhanhAdminService->disable($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Vô hiệu hóa thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }

    // hiển thị ảnh
    public function show(HinhAnh $hinhanh)
    {
        if ($hinhanh === null) {
            return redirect()->back()->with('error', 'Hình ảnh không tồn tại');
        }

        return view('admin.hinhanh.edit', [
            'title' => "Cập nhật ảnh",
            'hinhanh' => $hinhanh,
            'danhmucanh' => $this->hinhanhAdminService->getDanhMucAnh(),
            'catagory_img_childs' => $this->hinhanhAdminService->getDanhMucCon(),
        ]);
    }

    // Cập nhật ảnh 
    public function update(HinhAnh $hinhanh, FormRequest $request)
    {
        $result = $this->hinhanhAdminService->update($hinhanh, $request);
        if ($result) {
            return redirect('admin\hinhanh\list');
        }
        return redirect()->back();
    }

    // xóa hình ảnh
    public function destroy(Request $request)
    {
        $result = $this->hinhanhAdminService->delete($request);
        if ($result) {
            return response()->json([
                'error' => false, //thông báo cho client không có lỗi xảy ra 
                'message' => 'Xóa hình ảnh thành công'
            ]);
        }
        return response()->json(['error' => true]);
    }

    // Tăng lượt xem
    public function updateView($id)
    {
        HinhAnh::where('id', $id)->update([
            'view' => \DB::raw('view + 101'),
            'view_real' => \DB::raw('view_real + 1'),
        ]);

        $hinhAnh = HinhAnh::findOrFail($id); // Lấy lại giá trị cập nhật
        return response()->json(['success' => true, 'view' => $hinhAnh->view]);
    }


    // tăng lượt like 
    public function likeImage(Request $request)
    {
        try {
            $user = Auth::user();

            $imageId = $request->input('image_id');
            $image = HinhAnh::find($imageId);

            if (!$image) {
                return response()->json(['success' => false, 'message' => 'Hình ảnh không tồn tại.'], 404);
            }

            $existingLike = UserLike::where('user_id', $user->id)->where('hinhanh_id', $imageId)->first();

            if ($existingLike) {
                $existingLike->delete();
                $image->decrement('like_count');
                return response()->json(['success' => true, 'like_count' => $image->like_count, 'user_liked' => false]);
            } else {
                // Tạo mới UserLike mà không cần quan tâm đến created_at và updated_at
                UserLike::create([
                    'user_id' => $user->id,
                    'hinhanh_id' => $imageId,
                    'liked_at' => now(),
                ]);
                $image->increment('like_count');
                return response()->json(['success' => true, 'like_count' => $image->like_count, 'user_liked' => true]);
            }
        } catch (\Exception $e) {
            \Log::error("Lỗi khi thực hiện like: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi!'], 500);
        }
    }
}
