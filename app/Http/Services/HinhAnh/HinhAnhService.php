<?php

namespace App\Http\Services\HinhAnh;

use App\Models\HinhAnh;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucAnh;
use App\Models\CatagoryImgChild;
use App\Models\UserLike;
use Illuminate\Support\Facades\Log;
use Exception;
use DB;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class HinhAnhService
{
    //Lấy danh sách ảnh
    public function getAll()
    {
        return HinhAnh::with('category', 'category_child')
            ->join('catagory_img_child', 'hinhanh.category_child', '=', 'catagory_img_child.id')
            ->where('hinhanh.active', 1)
            ->where('catagory_img_child.name', '!=', '16+')
            ->orderBy('hinhanh.created_at', 'desc')
            ->select('hinhanh.*') // chỉ lấy dữ liệu từ bảng hinhanh
            ->paginate(40);
    }

    //Lấy ảnh theo ID
    public function getImg($id)
    {
        return HinhAnh::where('id', $id)
            ->where('active', 1)
            ->first();
    }



    //Lấy danh sách ảnh phổ biến
    public function getImg_popular()
    {
        return HinhAnh::with('category', 'category_child')
            ->where('active', 1)
            ->whereHas('category_child', fn($q) => $q->where('name', '!=', '16+'))
            ->orderBy('like_count', 'desc')
            ->paginate(40);
    }


    //Lấy danh sách ảnh theo lượt xem
    public function getImg_viewCount()
    {
        return HinhAnh::with('category', 'category_child')
            ->where('active', 1)
            ->whereHas('category_child', fn($q) => $q->where('name', '!=', '16+'))
            ->orderBy('view_real', 'desc')
            ->paginate(40);
    }


    //Lấy 40 ảnh random
    public function getImg_random()
    {
        return HinhAnh::with('category', 'category_child')
            ->inRandomOrder()
            ->where('active', 1)
            ->whereHas('category_child', fn($q) => $q->where('name', '!=', '16+'))
            ->paginate(40);
    }


    // Lấy 40 ảnh có thuộc tính direction = 1 (dọc)
    public function getImg_verticalImage()
    {
        return HinhAnh::with('category', 'category_child')
            ->where('direction', 1)
            ->where('active', 1)
            ->whereHas('category_child', fn($q) => $q->where('name', '!=', '16+'))
            ->paginate(40);
    }


    // Lấy 40 ảnh có thuộc tính direction = 0 (ngang)
    public function getImg_horizontalImage()
    {
        return HinhAnh::with('category', 'category_child')
            ->where('direction', 0)
            ->where('active', 1)
            ->whereHas('category_child', fn($q) => $q->where('name', '!=', '16+'))
            ->paginate(40);
    }


    // Lấy 40 ảnh theo danh mục
    public function getImg_category($id)
    {
        return HinhAnh::with('category')
            ->where('category_id', $id)
            ->where('active', 1)
            ->paginate(40);
    }

    // Lấy 40 ảnh theo danh mục con
    public function getImg_category_child($id)
    {
        // Lấy tên của danh mục con
        $categoryChild = DB::table('catagory_img_child')->where('id', $id)->first();

        if (!$categoryChild) {
            return collect(); // Trả về tập rỗng nếu không tìm thấy
        }

        $keyword = $categoryChild->name;

        // Lấy ảnh thỏa mãn điều kiện
        return HinhAnh::with('category', 'category_child')
            ->where('active', 1)
            ->where(function ($query) use ($id, $keyword) {
                $query->where('category_child', $id)
                    ->orWhere('description', 'like', '%' . $keyword . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }

    // Lấy danh sách danh mục con
    public function getcategory_childs($id)
    {
        return CatagoryImgChild::with('parent')
            ->where('parent_id', $id)
            ->where('active', 1)
            ->get()
            ->map(function ($danhmuc) {
                $locale = app()->getLocale();
                $cacheKey = 'translated_category_child_' . $danhmuc->id . '_' . $locale;

                $danhmuc->translated_name = Cache::remember($cacheKey, now()->addDays(7), function () use ($danhmuc, $locale) {
                    return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($danhmuc->name) : $danhmuc->name;
                });

                return $danhmuc;
            });
    }


    // Lấy danh mục con cùng cấp
    public function getSubcategories($id)
    {
        // Lấy danh mục con hiện tại
        $danhMucCon = CatagoryImgChild::where('id', $id)
            ->where('active', 1)
            ->first();

        if (!$danhMucCon) {
            return collect(); // Trả về collection rỗng để tránh lỗi khi gọi map
        }

        $parent_id = $danhMucCon->parent_id;

        // Lấy danh sách các danh mục con khác có cùng parent_id và dịch
        return CatagoryImgChild::where('parent_id', $parent_id)
            ->where('active', 1)
            ->get()
            ->map(function ($child) {
                $locale = app()->getLocale();
                $cacheKey = 'translated_subcategory_' . $child->id . '_' . $locale;

                $child->translated_name = Cache::remember($cacheKey, now()->addDays(7), function () use ($child, $locale) {
                    return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($child->name) : $child->name;
                });

                return $child;
            });
    }

    // Lấy 40 ảnh mà người dùng đã thích
    public function get_userlike($id)
    {
        return HinhAnh::join('user_likes', 'hinhanh.id', '=', 'user_likes.hinhanh_id')
            ->where('user_likes.user_id', $id)  // Lọc ảnh theo user_id
            ->select('hinhanh.*') // Lấy tất cả cột của bảng hinhanh
            ->orderByDesc('liked_at')
            ->paginate(40);  // Lấy 40 ảnh đầu tiên
    }

    // Lấy danh mục cha theo id
    public function getcategory_byID($id)
    {
        $danhmuc = DanhMucAnh::where('id', $id)
            ->where('active', 1)
            ->first();

        if ($danhmuc) {
            $locale = app()->getLocale();
            $cacheKey = 'translated_category_' . $danhmuc->id . '_' . $locale;

            $danhmuc->translated_name = Cache::remember($cacheKey, now()->addDays(7), function () use ($danhmuc, $locale) {
                return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($danhmuc->name) : $danhmuc->name;
            });
        }
        return $danhmuc;
    }

    // Lấy danh mục con theo id
    public function getcategory_child($id)
    {
        $child = CatagoryImgChild::with('parent')
            ->where('id', $id)
            ->where('active', 1)
            ->first();

        if ($child) {
            $locale = app()->getLocale();
            $cacheKey = 'translated_subcategory_' . $child->id . '_' . $locale;
            $child->translated_name = Cache::remember($cacheKey, now()->addDays(7), function () use ($child, $locale) {
                return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($child->name) : $child->name;
            });

            if ($child->parent) {
                $parentKey = 'translated_category_' . $child->parent->id . '_' . $locale;
                $child->parent->translated_name = Cache::remember($parentKey, now()->addDays(7), function () use ($child, $locale) {
                    return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($child->parent->name) : $child->parent->name;
                });
            }
        }

        return $child;
    }

    //lấy tổng số ảnh
    public function getTotalAnh()
    {
        return HinhAnh::count();
    }

    // Đếm số lượng ảnh theo danh mục
    // public function getDanhMucWithCount()
    // {
    //     return DanhMucAnh::where('active', 1)
    //         ->withCount(['images' => function ($query) {
    //             $query->where('active', 1); // Đếm ảnh có trạng thái 'active'
    //         }])
    //         ->get();
    // }
    public function getDanhMucWithCount()
    {
        return DanhMucAnh::where('active', 1)
            ->withCount(['images' => function ($query) {
                $query->where('active', 1); // Đếm ảnh có trạng thái 'active'
            }])
            ->orderByDesc('images_count') // Sắp xếp giảm dần theo số lượng ảnh
            // ->limit(10) // Giới hạn 10 danh mục
            ->get()
            ->map(function ($danhmuc) {
                $locale = app()->getLocale();
                $cacheKey = 'translated_category_' . $danhmuc->id . '_' . $locale;

                $danhmuc->translated_name = Cache::remember($cacheKey, now()->addDays(7), function () use ($danhmuc, $locale) {
                    return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($danhmuc->name) : $danhmuc->name;
                });
                return $danhmuc;
            });
    }


    // Lấy tất cả danh mục con có trạng thái 'active' và danh mục cha cũng phải 'active'
    public function getDanhMucCon()
    {
        return CatagoryImgChild::active()
            ->whereHas('parent', function ($query) {
                $query->active();
            })
            ->orderBy('name', 'asc') // Sắp xếp theo tên tăng dần
            ->get();
    }

    // xử lý tìm kiếm 
    // public function search_img($request)
    // {
    //     $keyword = $request->input('search');
    //     $keyword_like = '%' . $keyword . '%';

    //     $results = DB::select("
    //     SELECT ha.*, dm.id AS category_id, dm.name AS category_name, dmc.id AS category_child_id, dmc.name AS category_child_name
    //     FROM hinhanh ha
    //     LEFT JOIN danhmucanh dm ON ha.category_id = dm.id
    //     LEFT JOIN catagory_img_child dmc ON ha.category_child = dmc.id
    //     WHERE ha.active = 1
    //       AND (
    //         ha.id = ? OR
    //         ha.description LIKE ? OR
    //         dm.name LIKE ? OR
    //         dmc.name LIKE ?
    //       )
    //     ORDER BY 
    //       CASE 
    //         WHEN ha.id = ? THEN 1
    //         WHEN ha.description LIKE ? THEN 2
    //         WHEN dm.name LIKE ? THEN 3
    //         WHEN dmc.name LIKE ? THEN 4
    //         ELSE 5
    //       END
    //     LIMIT 10
    // ", [$keyword, $keyword_like, $keyword_like, $keyword_like, $keyword, $keyword_like, $keyword_like, $keyword_like]);

    //     $images = collect($results)->map(function ($item) {
    //         $item = (array)$item;  // Chuyển đối tượng stdClass thành mảng để dễ thao tác
    //         $item['category'] = (object)[
    //             'id' => $item['category_id'],
    //             'name' => $item['category_name']
    //         ];
    //         $item['category_child'] = (object)[
    //             'id' => $item['category_child_id'],
    //             'name' => $item['category_child_name']
    //         ];
    //         return (object)$item; // Trả về đối tượng để view có thể gọi `$image->category->name`
    //     });

    //     return $images;
    // }
}
