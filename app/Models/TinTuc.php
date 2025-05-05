<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TinTuc extends Model
{
    use HasFactory;

    protected $table = 'tintuc';

    protected $fillable = [
        'title',
        'content',
        'description',
        'author_id',
        'view',
        'view_fake',
        'active',
        'category_id',
    ];

    /**
     * Relationship with the author (User).
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id')->withDefault(['name' => '']);
    }

    /**
     * Relationship with category (DanhMucTin).
     */
    public function category()
    {
        return $this->belongsTo(DanhMucTin::class, 'category_id')->withDefault(['name' => '']);
    }

    /**
     * Relationship with images (TinTucImage).
     */
    public function images()
    {
        return $this->hasMany(TinTucImage::class, 'tintuc_id');
    }

    /**
     * Lấy full URL của ảnh đầu tiên từ tin_tuc_images.
     */
    protected function firstImageUrl(): Attribute
    {
        return Attribute::get(fn() => $this->images->first() ? $this->images->first()->full_url : asset('images/default.jpg'));
    }
}
