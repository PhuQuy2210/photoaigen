<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // Kiểm tra xem tệp có được tải lên không
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Lưu file vào thư mục upload/tintuc
            $filePath = $file->storeAs('public/upload/tintuc', $fileName);

            // Tạo URL truy cập ảnh
            $url = Storage::url(str_replace('public/', '', $filePath));

            return response()->json([
                'uploaded' => 1,
                'fileName' => $fileName,
                'url' => asset($url),
            ]);
        }

        // Trả về lỗi nếu không có file tải lên
        return response()->json(['uploaded' => 0, 'error' => ['message' => 'Tải ảnh không thành công!']]);
    }
}
