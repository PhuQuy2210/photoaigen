<?php

namespace App\Http\Services\TinTuc;

use Illuminate\Support\Facades\Session;
use App\Models\DanhMucAnh;
use App\Models\DanhMucTin;
use App\Models\TinTuc;
use App\Models\TinTucImage;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Exception;

class TinTucService
{
    //Lấy danh sách tin
    public function getAll()
    {
        return TinTuc::select('*')->paginate(10);
    }

    //Lấy danh sách tin đang hoạt động
    public function getAll_active()
    {
        return DanhMucTin::where('active', 1)->get();
    }

    //Lấy danh sách user
    public function getAll_users()
    {
        return User::where('is_active', 1)->get();
    }

    //lấy danh sách danh mục
    public function getDanhMucAnh()
    {
        return DanhMucAnh::where('active', 1)->get();
    }

    public function enable($request)
    {
        $result = TinTuc::where('id', $request->input('id'))->first();
        if ($result) {
            $result->active = 1; // Kích hoạt
            $result->save();
            return true;
        }
        return false;
    }

    public function disable($request)
    {
        $result = TinTuc::where('id', $request->input('id'))->first();
        if ($result) {
            $result->active = 0; // Vô hiệu hóa
            $result->save();
            return true;
        }
        return false;
    }

    public function insert($request)
    {
        try {
            // Lấy dữ liệu cho bảng tintuc
            $data = $request->only(['title', 'content', 'description', 'author_id', 'category_id']);
            $data['active'] = 1;
            $data['view'] = 1;
            $data['view_fake'] = rand(1000, 5000); // Thêm view giả
            
            // Tạo bản ghi TinTuc
            $tintuc = TinTuc::create($data);

            // Xử lý upload ảnh nếu có
            if ($request->hasFile('url')) {
                $files = $request->file('url');

                foreach ($files as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $filename = uniqid() . '.' . $extension;

                    // Đường dẫn lưu ảnh trên S3
                    $imagePath = 'blogs/' . $filename;

                    // Upload ảnh lên S3
                    Storage::disk('s3')->put($imagePath, file_get_contents($file));

                    // Lưu đường dẫn vào bảng tin_tuc_images
                    TinTucImage::create([
                        'tintuc_id' => $tintuc->id,
                        'url' => $imagePath,
                    ]);
                }
            }

            Session::flash('success', 'Thêm bản tin thành công!');
            return true;
        } catch (Exception $err) {
            Log::error('Lỗi khi thêm tin tức:', ['message' => $err->getMessage()]);
            Session::flash('error', 'Lỗi: ' . $err->getMessage());
            return false;
        }
    }

    // public function insert($request)
    // {
    //     try {
    //         $data = $request->only(['title', 'content', 'description', 'author_id', 'category_id']);
    //         $imagePaths = [];

    //         if ($request->hasFile('url')) {
    //             $files = $request->file('url');

    //             foreach ($files as $file) {
    //                 $extension = $file->getClientOriginalExtension();
    //                 $filename = uniqid() . '.' . $extension;

    //                 // Đường dẫn lưu ảnh trên S3
    //                 $imagePath = 'blogs/' . $filename;

    //                 // Upload ảnh lên S3
    //                 Storage::disk('s3')->put($imagePath, file_get_contents($file));

    //                 // Thêm đường dẫn vào mảng
    //                 $imagePaths[] = $imagePath;
    //             }

    //             // Lưu vào DB
    //             $data['url'] = json_encode($imagePaths); // 👈 Lưu danh sách ảnh dạng JSON
    //             $data['active'] = 1;
    //             $data['view'] = 1;

    //             TinTuc::create($data);

    //             Session::flash('success', 'Thêm bản tin thành công!');
    //             return true;
    //         } else {
    //             throw new Exception("Vui lòng chọn ít nhất một hình ảnh.");
    //         }
    //     } catch (Exception $err) {
    //         Log::error('Lỗi khi upload ảnh:', ['message' => $err->getMessage()]);
    //         Session::flash('error', 'Lỗi: ' . $err->getMessage());
    //         return false;
    //     }
    // }

    public function update($tintuc, $request)
    {
        $img = $tintuc;

        // Kiểm tra xem có file thumb trong request không
        if ($request->hasFile('url')) {
            $file = $request->file('url');
            $extension = $file->getClientOriginalExtension();
            $filename = 'upload/tintuc/' . time() . '.' . $extension;

            // Xóa file cũ nếu tồn tại
            if ($img->url && file_exists(public_path($img->url))) {
                unlink(public_path($img->url));
            }

            $file->move(public_path('upload/tintuc'), $filename);

            $img->url = $filename;
        } else {
            // Nếu không có file mới, giữ nguyên đường dẫn file cũ
            $img->url = $request->input('url_old');
        }

        // Cập nhật các trường dữ liệu khác
        $tintuc->title = $request->input('title');
        $tintuc->author_id = $request->input('author_id');
        $tintuc->description = $request->input('description');
        $tintuc->content = $request->input('content');
        $tintuc->view = $request->input('view');
        $tintuc->active = $request->input('active');
        $tintuc->category_id = $request->input('category_id');

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

    // xóa tin tức
    public function delete($request)
    {
        $result = TinTuc::where('id', $request->input('id'))->first();

        if ($result) {
            $result->delete();
            return true;
        }
        return false;
    }
}
