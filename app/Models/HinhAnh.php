<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HinhAnh extends Model
{
    use HasFactory;

    protected $table = 'hinhanh'; // Đảm bảo tên bảng đúng với cơ sở dữ liệu

    // Laravel sẽ tự động quản lý các cột `created_at` và `updated_at`
    public $timestamps = true;

    protected $fillable = [
        'url',
        'thumb_path', // thêm dòng này nè
        'description',
        'active',
        'direction',
        'view',
        'like_count',
        'category_id',
        'category_child',
    ];

    // Lấy full URL ảnh gốc
    protected function fullUrl(): Attribute
    {
        return Attribute::get(fn() => config('filesystems.disks.s3.url') . '/' . $this->url);
    }

    // Lấy full URL thumbnail
    protected function fullThumb(): Attribute
    {
        return Attribute::get(fn() => config('filesystems.disks.s3.url') . '/' . $this->thumb_path);
    }

    /**
     * Relationship with category (DanhMucAnh).
     */
    public function category()
    {
        return $this->belongsTo(DanhMucAnh::class, 'category_id');
    }

    /**
     * Relationship with category (DanhMucCon).
     */
    public function category_child()
    {
        return $this->belongsTo(CatagoryImgChild::class, 'category_child');
    }

    /**
     * Relationship with users who liked the image.
     */
    public function likes()
    {
        return $this->hasMany(UserLike::class, 'hinhanh_id');
    }

    /**
     * Kiểm tra nếu người dùng hiện tại đã thích ảnh này.
     */
    public function getUserHasLikedAttribute()
    {
        if (Auth::check()) {
            return $this->likes()->where('user_id', Auth::id())->exists();
        }
        return false;
    }

    // Phương thức để đếm số lượng "like"
    public function likesCount()
    {
        return $this->likes()->count();
    }

    /**
     * Relationship with reports (Báo Cáo).
     */
    public function baocaos()
    {
        return $this->hasMany(BaoCao::class, 'hinhanh_id');
    }
}
