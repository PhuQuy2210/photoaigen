<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Services\HinhAnh\HinhAnhService;
use App\Models\HinhAnh;
use App\Models\SocialAccount;
use Auth;

class MainController extends Controller
{
    protected $hinhanhService;

    public function __construct(HinhAnhService $hinhanhService)
    {
        $this->hinhanhService = $hinhanhService;
    }

    // danh sách ảnh
    public function index(Request $request)
    {
        return view('home', [
            'title' => 'Danh Sách Hình Ảnh',
            'lists' => $this->hinhanhService->getAll(),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    public function search(Request $request)
    {
        $query = HinhAnh::with('category')
            ->where('active', 1);

        // Kiểm tra nếu có từ khóa tìm kiếm
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', "{$search}")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $lists = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $request->search]); // Giữ lại tham số search khi chuyển trang


        return view('search', [
            'title' => 'tìm kiếm Hình Ảnh',
            'lists' => $lists,
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    // about us
    public function about_us()
    {
        return view('introduce.info', [
            'title' => '',
        ]);
    }

    
    public function contact_us()
    {
        return view('introduce.contact', [
            'title' => '',
        ]);
    }

    public function terms_of_Service()
    {
        return view('introduce.terms_of_Service', [
            'title' => '',
        ]);
    }

    public function privacy_Policy()
    {
        return view('introduce.privacy_Policy', [
            'title' => '',
        ]);
    }
    
    // public function getImages(Request $request)
    // {
    //     $perPage = 10;
    //     $page = $request->input('page', 1);
    //     $offset = ($page - 1) * $perPage;

    //     $duong_dan = $request->input('duong_dan');
    //     $value = $request->input('value');

    //     $query = HinhAnh::query();

    //     switch ($duong_dan) {
    //         case 'images-popular':
    //             $query->orderBy('like_count', 'desc');
    //             break;
    //         case 'images-random':
    //             $query->inRandomOrder();
    //             break;
    //         case 'images-vertical':
    //             $query->where('direction', 1);
    //             break;
    //         case 'images-horizontal':
    //             $query->where('direction', 0);
    //             break;
    //         case 'images-categories':
    //             if (isset($value)) {
    //                 $query->where('category_id', $value);
    //             }
    //             break;
    //         case 'images-categories-child':
    //             $query->where('category_child', $value);
    //             break;
    //         case 'images-user-like':
    //             $query->join('user_likes', 'hinhanh.id', '=', 'user_likes.hinhanh_id')
    //                 ->where('user_likes.user_id', $value);
    //             break;
    //         default:
    //             $query->orderBy('created_at', 'desc');
    //     }

    //     // Đếm tổng số ảnh trước khi phân trang
    //     $totalImages = $query->where('active', 1)->count();

    //     // Lấy dữ liệu phân trang
    //     $images = $query->where('active', 1) // Đảm bảo điều kiện "active"
    //         ->skip($offset)
    //         ->take($perPage)
    //         ->with('category')
    //         ->get();

    //     // Thêm thông tin userHasLiked vào mỗi ảnh
    //     $images->each(function ($image) {
    //         $image->userHasLiked = $image->getUserHasLikedAttribute();
    //     });

    //     return response()->json([
    //         'lists' => $images,
    //         'totalImages' => $totalImages,
    //         'duongdan' => $duong_dan,
    //         'value' => $value,
    //     ]);
    // }

    public function popular()
    {
        return view('category_images.catagoryImages', [
            'title' => 'Ảnh phổ biến',
            'lists' => $this->hinhanhService->getImg_popular(),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    public function viewCount()
    {
        return view('category_images.catagoryImages', [
            'title' => 'Ảnh phổ biến',
            'lists' => $this->hinhanhService->getImg_viewCount(),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    public function random()
    {
        return view('category_images.catagoryImages', [
            'title' => 'Ảnh ngẫu nhiên',
            'lists' => $this->hinhanhService->getImg_random(),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    public function verticalImage()
    {
        return view('category_images.catagoryImages', [
            'title' => 'Ảnh dọc',
            'lists' => $this->hinhanhService->getImg_verticalImage(),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    public function horizontalmage()
    {
        return view('category_images.catagoryImages', [
            'title' => 'Ảnh ngang',
            'lists' => $this->hinhanhService->getImg_horizontalImage(),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    // bộ sưu tập controller
    public function userlike($id)
    {
        return view('category_images.catagoryImages', [
            'title' => 'userlike',
            'lists' => $this->hinhanhService->get_userlike($id), // Lấy 20 ảnh đã like
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }



    // lấy ảnh theo danh mục
    public function category_image($id)
    {
        return view('category_images.categories', [
            'title' => 'Ảnh theo danh mục',
            'lists' => $this->hinhanhService->getImg_category($id),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'danhmuccons' => $this->hinhanhService->getcategory_childs($id),
            'danhmucID' => $this->hinhanhService->getcategory_byID($id),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    // lấy ảnh theo danh mục con
    public function category_image_chils($id)
    {
        return view('category_images.categories-child', [
            'title' => 'Ảnh theo danh mục con',
            'lists' => $this->hinhanhService->getImg_category_child($id),
            'danhmucs' => $this->hinhanhService->getDanhMucWithCount(),
            'danhmuccons' => $this->hinhanhService->getSubcategories($id),
            'name_danhmuccon' => $this->hinhanhService->getcategory_child($id),
            'totalImages' => $this->hinhanhService->getTotalAnh(),
        ]);
    }

    // chuyển hướng đến trang báo cáo 
    public function report($iduser, $idimg)
    {
        return view('baocao.report', [
            'title' => 'Ảnh theo danh mục con',
            'image' => $this->hinhanhService->getImg($idimg),

        ]);
    }

    //xử lý thêm báo cáo
    public function baocao_Store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'country' => 'required|string|max:255',
            'original_link' => 'required|url',
            'details' => 'required|string',
            'commitment' => 'accepted',
        ]);

        // Xử lý lưu thông tin vào cơ sở dữ liệu
        // ...

        return redirect()->back()->with('success', 'Báo cáo vi phạm đã được gửi.');
    }
}
