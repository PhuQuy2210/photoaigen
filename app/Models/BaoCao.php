<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaoCao extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'baocao';

    // Các trường có thể gán dữ liệu thông qua phương thức mass-assignment
    protected $fillable = [
        'user_id',
        'hinhanh_id',
        'email',
        'sdt',
        'quocgia',
        'url',
        'kiemduyet',
        'description',
    ];

    protected $casts = [
        'kiemduyet' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Quan hệ với model User
     * Một báo cáo thuộc về một người dùng
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Quan hệ với model HinhAnh
     * Một báo cáo thuộc về một hình ảnh
     */
    public function hinhanh()
    {
        return $this->belongsTo(HinhAnh::class, 'hinhanh_id');
    }
}
