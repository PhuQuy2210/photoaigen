<?php

namespace App\Http\Controllers;

use App\Models\TinTucImage;
use Illuminate\Http\Request;
use Storage;
use Illuminate\Support\Facades\Response;

class ImageController extends Controller
{
    public function download(Request $request)
    {
        $url = $request->query('url');

        if (!$url) {
            abort(404);
        }

        $path = parse_url($url, PHP_URL_PATH);
        $path = ltrim($path, '/');

        if (!Storage::disk('s3')->exists($path)) {
            abort(404, 'File không tồn tại');
        }

        $fileContent = Storage::disk('s3')->get($path);
        $mimeType = Storage::disk('s3')->mimeType($path);

        $filename = basename($path); // Lấy tên file cuối cùng

        return response($fileContent)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}

