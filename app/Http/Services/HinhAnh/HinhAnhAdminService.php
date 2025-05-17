<?php

namespace App\Http\Services\HinhAnh;

use App\Models\HinhAnh;
use App\Models\UserLike;
use Illuminate\Support\Facades\Session;
use App\Models\DanhMucAnh;
use App\Models\CatagoryImgChild;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Exception;
use Intervention\Image\Drivers\Gd\Driver; // hoặc Imagick nếu thích


class HinhAnhAdminService
{
    //Lấy danh sách ảnh
    public function getAll()
    {
        return HinhAnh::with('category', 'category_child')->select('*')->paginate(10);
    }

    //lấy danh sách danh mục
    public function getDanhMucAnh()
    {
        return DanhMucAnh::where('active', 1)->get();
    }

    // Lấy tất cả danh mục con có trạng thái 'active' và danh mục cha cũng phải 'active'
    // public function getDanhMucCon()
    // {
    //     return CatagoryImgChild::active()
    //         ->whereHas('parent', function ($query) {
    //             $query->active();
    //         })
    //         ->orderBy('name', 'asc') // Sắp xếp theo tên tăng dần
    //         ->get();
    // }
    
    public function getDanhMucCon()
    {
        return CatagoryImgChild::active()
            ->whereHas('parent', function ($query) {
                $query->active();
            })
            ->select('*') // lấy tất cả trường
            ->selectRaw('LOWER(name) as lower_name') // tạo trường tạm lower_name
            ->orderBy('name', 'asc')
            ->get()
            ->unique('lower_name') // lọc trùng dựa theo lower_name
            ->values(); // reset lại key cho đẹp
    }

    public function insert($request)
    {
        try {
            $dataCommon = $request->only(['description', 'direction', 'category_id', 'category_child']);

            if ($request->hasFile('url')) {
                $files = $request->file('url');
                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = uniqid() . '.' . $extension;

                    // Đường dẫn trên S3
                    $imagePath = 'images/' . $filename;
                    $thumbPath = 'thumbnails/' . $filename;

                    // Upload ảnh gốc lên S3
                    Storage::disk('s3')->put($imagePath, file_get_contents($file));

                    // Tạo thumbnail và upload
                    $manager = new ImageManager(new Driver());
                    $thumbnail = $manager->read($file)->scaleDown(width: 500)->toJpeg();
                    Storage::disk('s3')->put($thumbPath, $thumbnail);

                    // Lưu vào DB
                    $data = $dataCommon; // clone dữ liệu chung
                    $data['url'] = $imagePath;
                    $data['thumb_path'] = $thumbPath;
                    $data['active'] = 1;
                    $data['view'] = 1;
                    $data['like_count'] = rand(10, 500);

                    HinhAnh::create($data);
                }
                Session::flash('success', 'Đã thêm ' . count($files) . ' hình ảnh!');
                return true;
            } else {
                throw new Exception("Vui lòng chọn ít nhất một hình ảnh. Ảnh = ", $request->hasFile('url'));
            }
        } catch (Exception $err) {
            Log::error('Lỗi khi upload ảnh:', ['message' => $err->getMessage()]);
            Session::flash('error', 'Lỗi: ' . $err->getMessage());
            return false;
        }
    }

    public function enable($request)
    {
        $result = HinhAnh::where('id', $request->input('id'))->first();
        if ($result) {
            $result->active = 1; // Kích hoạt
            $result->save();
            return true;
        }
        return false;
    }

    public function disable($request)
    {
        $result = HinhAnh::where('id', $request->input('id'))->first();
        if ($result) {
            $result->active = 0; // Vô hiệu hóa
            $result->save();
            return true;
        }
        return false;
    }

    public function delete($request)
    {
        // Xóa các bản ghi liên quan trong bảng user_likes
        UserLike::where('hinhanh_id', $request->input('idimg'))->delete();


        $result = HinhAnh::where('id', $request->input('id'))->first();

        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }

    public function update($hinhanh, $request)
    {
        $img = $hinhanh;

        // Kiểm tra xem có file ảnh trong request không
        if ($request->hasFile('url')) {
            $file = $request->file('url');
            $extension = $file->getClientOriginalExtension();
            $filename = 'upload/hinhanh/' . time() . '.' . $extension;

            if ($img->url && file_exists(public_path($img->url))) {
                unlink(public_path($img->url));
            }

            $file->move(public_path('upload/hinhanh'), $filename);

            $img->url = $filename;
        } else {
            // Nếu không có file mới, giữ nguyên đường dẫn file cũ
            $img->url = $request->input('url_old');
        }

        // Cập nhật các trường dữ liệu khác        
        $img->category_id = $request->input('title');
        $img->category_id = $request->input('category_id');
        $img->category_child = $request->input('category_child');
        $img->description = $request->input('description');
        $img->view = $request->input('view');
        $img->like_count = $request->input('like_count');
        $img->active = $request->input('active') ? 1 : 0; // Kiểm tra xem active có được chọn không
        $img->direction = $request->input('direction') ?? 1; // Nếu không có giá trị direction thì mặc định là Ngang

        try {
            $img->save();
            Session::flash('success', 'Cập nhật hình ảnh thành công');
        } catch (Exception $e) {
            Log::error('Lỗi khi cập nhật hình ảnh: ' . $e->getMessage());
            Session::flash('error', 'Cập nhật hình ảnh thất bại. Vui lòng thử lại.');
            return false;
        }

        return true;
    }
}
