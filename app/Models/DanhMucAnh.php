<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucAnh extends Model
{
    use HasFactory;
    protected $table = 'danhmucanh'; // Đặt tên bảng chính xác ở đây
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'active',
    ];

    /**
     * Relationship with images (HinhAnh).
     */
    public function images()
    {
        return $this->hasMany(HinhAnh::class,  'category_id', 'id');
    }

    // Định nghĩa mối quan hệ: Danh mục cha có nhiều danh mục con
    public function children()
    {
        return $this->hasMany(CatagoryImgChild::class, 'parent_id');
    }

    // Định nghĩa phạm vi: Lọc danh mục cha đang kích hoạt
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
