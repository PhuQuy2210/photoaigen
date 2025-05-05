<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class TinTucImage extends Model
{
    use HasFactory;

    protected $table = 'tin_tuc_images';

    protected $fillable = [
        'tintuc_id',
        'url',
    ];

    public $timestamps = true;

    /**
     * Relationship with TinTuc.
     */
    public function tintuc()
    {
        return $this->belongsTo(TinTuc::class, 'tintuc_id');
    }

    /**
     * Lấy full URL của ảnh.
     */
    protected function fullUrl(): Attribute
    {
        return Attribute::get(fn() => config('filesystems.disks.s3.url') . '/' . $this->url);
    }


}