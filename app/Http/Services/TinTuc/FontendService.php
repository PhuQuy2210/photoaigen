<?php

namespace App\Http\Services\TinTuc;

use App\Models\DanhMucTin;
use App\Models\TinTuc;
use App\Models\TinTucImage;
use Illuminate\Support\Facades\Cache;
use Log;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FontendService
{
    // Lấy danh sách bài viết đang hoạt động
    // public function getAll_active()
    // {
    //     return TinTuc::with('category') // Liên kết danh mục
    //         ->where('active', 1) // Điều kiện chỉ lấy bài viết đang hoạt động
    //         ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo giảm dần
    //         ->paginate(5);
    // }

    public function getAll_active()
    {
        return TinTuc::with('category')
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->through(function ($tintuc) {
                $locale = app()->getLocale();

                if ($locale === 'en') {
                    $translator = new GoogleTranslate('en');

                    // Title
                    $cacheKeyTitle = 'translated_title_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_title = Cache::remember($cacheKeyTitle, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->title);
                    });

                    // Description
                    $cacheKeyDescription = 'translated_description_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_description = Cache::remember($cacheKeyDescription, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->description);
                    });

                    // Content
                    $cacheKeyContent = 'translated_content_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_content = Cache::remember($cacheKeyContent, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->content);
                    });
                } else {
                    // Nếu là tiếng Việt thì giữ nguyên
                    $tintuc->translated_title = $tintuc->title;
                    $tintuc->translated_description = $tintuc->description;
                    $tintuc->translated_content = $tintuc->content;
                }
                return $tintuc;
            });
    }

    // Lấy danh sách bài viết ngẫu nhiên 
    public function getAll_random()
    {
        return TinTuc::with('category') // Liên kết danh mục
            ->where('active', 1) // Điều kiện chỉ lấy bài viết đang hoạt động
            ->inRandomOrder() // Lấy ngẫu nhiên
            ->paginate(5)
            ->through(function ($tintuc) {
                $locale = app()->getLocale();

                if ($locale === 'en') {
                    $translator = new GoogleTranslate('en');

                    // Title
                    $cacheKeyTitle = 'translated_title_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_title = Cache::remember($cacheKeyTitle, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->title);
                    });

                    // Description
                    $cacheKeyDescription = 'translated_description_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_description = Cache::remember($cacheKeyDescription, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->description);
                    });

                    // Content
                    $cacheKeyContent = 'translated_content_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_content = Cache::remember($cacheKeyContent, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->content);
                    });
                } else {
                    // Nếu là tiếng Việt thì giữ nguyên
                    $tintuc->translated_title = $tintuc->title;
                    $tintuc->translated_description = $tintuc->description;
                    $tintuc->translated_content = $tintuc->content;
                }

                return $tintuc;
            });
    }

    // lấy danh sách danh mục tin tức
    public function getDanhMucTin()
    {
        return DanhMucTin::where('active', 1)->get()->map(function ($danhmuc) {
            $locale = app()->getLocale();
            $cacheKey = 'translated_danhmuctin_name_' . $danhmuc->id . '_' . $locale;

            $danhmuc->translated_name = Cache::remember($cacheKey, now()->addDays(30), function () use ($danhmuc, $locale) {
                return ($locale == 'en') ? (new GoogleTranslate('en'))->translate($danhmuc->name) : $danhmuc->name;
            });

            return $danhmuc;
        });
    }

    // Lấy bài viết theo danh mục
    public function blogs_byCategory($categoryId)
    {
        return TinTuc::where('category_id', $categoryId)
            ->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(8)
            ->through(function ($tintuc) {
                $locale = app()->getLocale();

                if ($locale === 'en') {
                    $translator = new GoogleTranslate('en');

                    // Title
                    $cacheKeyTitle = 'translated_title_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_title = Cache::remember($cacheKeyTitle, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->title);
                    });

                    // Description
                    $cacheKeyDescription = 'translated_description_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_description = Cache::remember($cacheKeyDescription, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->description);
                    });

                    // Content
                    $cacheKeyContent = 'translated_content_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_content = Cache::remember($cacheKeyContent, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->content);
                    });
                } else {
                    // Nếu là tiếng Việt thì giữ nguyên
                    $tintuc->translated_title = $tintuc->title;
                    $tintuc->translated_description = $tintuc->description;
                    $tintuc->translated_content = $tintuc->content;
                }
                return $tintuc;
            });
    }



    // Lấy bài viết phổ biến sắp xếp theo lượt xem
    public function blog_popular()
    {
        return TinTuc::where('active', 1) // Điều kiện chỉ lấy bài viết đang hoạt động
            ->orderBy('view', 'desc') // Sắp xếp theo lượt xem giảm dần
            ->paginate(5)
            ->through(function ($tintuc) {
                $locale = app()->getLocale();

                if ($locale === 'en') {
                    $translator = new GoogleTranslate('en');

                    // Title
                    $cacheKeyTitle = 'translated_title_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_title = Cache::remember($cacheKeyTitle, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->title);
                    });

                    // Description
                    $cacheKeyDescription = 'translated_description_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_description = Cache::remember($cacheKeyDescription, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->description);
                    });

                    // Content
                    $cacheKeyContent = 'translated_content_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_content = Cache::remember($cacheKeyContent, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->content);
                    });
                } else {
                    // Nếu là tiếng Việt thì giữ nguyên
                    $tintuc->translated_title = $tintuc->title;
                    $tintuc->translated_description = $tintuc->description;
                    $tintuc->translated_content = $tintuc->content;
                }

                return $tintuc;
            });
    }

    // Lấy danh sách bài viết liên quan dựa theo id bài viết (và từ đó lấy id danh mục tìm ra bài viết liên quan)
    public function blogs_byID($id)
    {
        // Lấy bài viết theo id
        $blog = TinTuc::select('category_id')->where('id', $id)->first();

        if (!$blog) {
            return collect(); // Trả về collection rỗng nếu không tìm thấy bài viết
        }

        return TinTuc::where('category_id', $blog->category_id) // Lấy bài viết theo danh mục của bài viết
            // ->where('id', '!=', $id) // ❗ Ngoại trừ bài viết hiện tại    
            ->where('active', 1) // Điều kiện chỉ lấy bài viết đang hoạt động
            ->orderBy('created_at', 'desc') // Sắp xếp theo thời gian tạo giảm dần
            ->paginate(5)
            ->through(function ($tintuc) {
                $locale = app()->getLocale();

                if ($locale === 'en') {
                    $translator = new GoogleTranslate('en');

                    // Title
                    $cacheKeyTitle = 'translated_title_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_title = Cache::remember($cacheKeyTitle, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->title);
                    });

                    // Description
                    $cacheKeyDescription = 'translated_description_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_description = Cache::remember($cacheKeyDescription, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->description);
                    });

                    // Content
                    $cacheKeyContent = 'translated_content_' . $tintuc->id . '_' . $locale;
                    $tintuc->translated_content = Cache::remember($cacheKeyContent, now()->addDays(30), function () use ($translator, $tintuc) {
                        return $translator->translate($tintuc->content);
                    });
                } else {
                    // Nếu là tiếng Việt thì giữ nguyên
                    $tintuc->translated_title = $tintuc->title;
                    $tintuc->translated_description = $tintuc->description;
                    $tintuc->translated_content = $tintuc->content;
                }

                return $tintuc;
            });
    }


    // Lấy 1 bài viết theo id
    public function blog_byID($id)
    {
        $tintuc = TinTuc::with(['category', 'images'])
            ->where('id', $id)
            ->where('active', 1)
            ->first();

        if (!$tintuc) {
            return null;
        }

        $locale = app()->getLocale();

        if ($locale === 'en') {
            $translator = new GoogleTranslate('en');

            // Title
            $cacheKeyTitle = 'translated_title_' . $tintuc->id . '_' . $locale;
            $tintuc->translated_title = Cache::remember($cacheKeyTitle, now()->addDays(30), function () use ($translator, $tintuc) {
                return $translator->translate($tintuc->title);
            });

            // Description
            $cacheKeyDescription = 'translated_description_' . $tintuc->id . '_' . $locale;
            $tintuc->translated_description = Cache::remember($cacheKeyDescription, now()->addDays(30), function () use ($translator, $tintuc) {
                return $translator->translate($tintuc->description);
            });

            // Content
            $cacheKeyContent = 'translated_content_' . $tintuc->id . '_' . $locale;
            $tintuc->translated_content = Cache::remember($cacheKeyContent, now()->addDays(30), function () use ($translator, $tintuc) {
                return $translator->translate($tintuc->content);
            });
        } else {
            // Nếu là tiếng Việt thì giữ nguyên
            $tintuc->translated_title = $tintuc->title;
            $tintuc->translated_description = $tintuc->description;
            $tintuc->translated_content = $tintuc->content;
        }
        $tintuc->increment('view', 1);
        $tintuc->increment('view_fake', 5);
        return $tintuc;
    }

    // Lấy danh sách ảnh theo id bài viết 
    public function blog_images_byID($id)
    {
        $blog = TinTucImage::where('tintuc_id', $id)
            ->get();
        return $blog;
    }


    public function category_byID($id)
    {
        // Lấy bài viết theo id để tìm danh mục
        $blog = TinTuc::select('category_id')->where('id', $id)->first();

        if (!$blog) {
            return null;
        }

        $danhMuc = DanhMucTin::where('id', $blog->category_id)
            ->where('active', 1)
            ->first();

        if (!$danhMuc) {
            return null;
        }

        // Dịch tên danh mục nếu cần
        $locale = app()->getLocale();
        if ($locale === 'en') {
            $cacheKey = 'translated_category_name_' . $danhMuc->id . '_' . $locale;
            $translator = new GoogleTranslate('en');

            $danhMuc->translated_name = Cache::remember($cacheKey, now()->addDays(30), function () use ($translator, $danhMuc) {
                return $translator->translate($danhMuc->name);
            });
        } else {
            $danhMuc->translated_name = $danhMuc->name;
        }

        return $danhMuc;
    }


    // tách đoạn để chèn quảng cáo 
    public function splitContent($id)
    {
        // Truy vấn bài viết từ cơ sở dữ liệu bằng ID
        $blog = TinTuc::find($id);

        // Kiểm tra nếu bài viết không tồn tại
        if (!$blog) {
            return [
                'first_paragraph' => '',
                'last_paragraph' => '',
                'remaining_content' => ''
            ];
        }

        // Lấy nội dung bài viết
        $content = $blog->content;

        // Tách nội dung thành các đoạn dựa vào ký tự xuống dòng
        $paragraphs = explode("\n", $content);

        return [
            'first_paragraph' => $paragraphs[0] ?? '', //lấy đoạn đầu
            'last_paragraph' => end($paragraphs) ?? '', // lấy đoạn cuối
            'remaining_content' => implode("\n", array_slice($paragraphs, 1, -1)) // Phần giữa
        ];
    }
}
