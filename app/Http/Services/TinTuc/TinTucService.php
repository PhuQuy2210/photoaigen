<?php

namespace App\Http\Services\TinTuc;

use Illuminate\Support\Facades\Session;
use App\Models\DanhMucAnh;
use App\Models\DanhMucTin;
use App\Models\TinTuc;
use App\Models\TinTucImage;
use App\Models\User;
use DB;
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

    public function update($tintuc, $request)
    {
        DB::beginTransaction(); // Bắt đầu transaction
        try {
            // Cập nhật thông tin tin tức
            $tintuc->title = $request->input('title');
            $tintuc->author_id = $request->input('author_id');
            $tintuc->description = $request->input('description');
            $tintuc->content = $request->input('content');
            $tintuc->view = $request->input('view');
            $tintuc->active = $request->input('active');
            $tintuc->category_id = $request->input('category_id');
            $tintuc->save();

            // Xử lý upload hình ảnh mới
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

            // Xóa hình ảnh cũ nếu có yêu cầu
            if ($request->input('delete_images')) {
                $imagesToDelete = $request->input('delete_images');
                foreach ($imagesToDelete as $imageId) {
                    $image = TinTucImage::find($imageId);
                    if ($image) {
                        // Xóa file khỏi S3
                        if (Storage::disk('s3')->exists($image->url)) {
                            Storage::disk('s3')->delete($image->url);
                        }
                        // Xóa bản ghi khỏi DB
                        $image->delete();
                    }
                }
            }

            DB::commit(); // Hoàn tất transaction
            Session::flash('success', 'Cập nhật tin tức và hình ảnh thành công!');
            return true;
        } catch (Exception $err) {
            DB::rollBack(); // Rollback nếu có lỗi
            Log::error('Lỗi khi cập nhật tin tức:', ['message' => $err->getMessage()]);
            Session::flash('error', 'Cập nhật thất bại. Lỗi: ' . $err->getMessage());
            return false;
        }
    }


    // xóa tin tức
    public function delete($request)
    {
        $tintuc = TinTuc::where('id', $request->input('id'))->first();

        if ($tintuc) {
            // Lấy tất cả các ảnh liên quan đến tin tức
            $images = TinTucImage::where('tintuc_id', $tintuc->id)->get();

            foreach ($images as $image) {
                // Kiểm tra và xóa ảnh trên S3
                if (Storage::disk('s3')->exists($image->url)) {
                    Storage::disk('s3')->delete($image->url);
                }
                // Xóa bản ghi ảnh trong cơ sở dữ liệu
                $image->delete();
            }

            // Xóa tin tức
            $tintuc->delete();

            return true;
        }
        return false;
    }
}
