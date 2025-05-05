<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Services\Slider\SliderService;
use App\Http\Services\TinTuc\FontendService;

class BlogController extends Controller
{
    protected $fontendService;

    public function __construct(FontendService $fontendService)
    {
        $this->fontendService = $fontendService;
    }

    public function index()
    {
        return view("blog.blog", [
            'title' => "Trang blog",
            'lists' => $this->fontendService->getAll_active(),
            'danhmucs' => $this->fontendService->getDanhMucTin(),
            'blogs_random' => $this->fontendService->getAll_random(),
        ]);
    }

    public function blog_popular()
    {
        return view("blog.blog", [
            'title' => "Trang blog",
            'lists' => $this->fontendService->blog_popular(),
            'danhmucs' => $this->fontendService->getDanhMucTin(),
            'blogs_random' => $this->fontendService->getAll_random(),
        ]);
    }

    public function blog_category($id)
    {
        return view("blog.blog", [
            'title' => "Trang blog",
            'lists' => $this->fontendService->blogs_byCategory($id),
            'danhmucs' => $this->fontendService->getDanhMucTin(),
            'danhmuc' => $this->fontendService->category_byID($id),
            'blogs_random' => $this->fontendService->getAll_random(),
        ]);
    }

    public function blogdetail($id)
    {
        return view("blog.blogdetail", [
            'title' => "Trang blogdetail",
            'blogs' => $this->fontendService->blogs_byID($id),// danh sách 5 bài viết liên quan
            'blog' => $this->fontendService->blog_byID($id),
            'blogImages' => $this->fontendService->blog_images_byID($id),
            'danhmucs' => $this->fontendService->getDanhMucTin(),
            'danhmuc' => $this->fontendService->category_byID($id),// danh mục của bài viết hiện tại
            'contentParts' => $this->fontendService->splitContent($id),
        ]);
    }
}
