<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatagoryImgChild extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'catagory_img_child';
    public $timestamps = false;

    // Các cột có thể được gán giá trị (mass assignable)
    protected $fillable = [
        'name',       // Tên danh mục con
        'parent_id',  // ID danh mục cha
        'active'      // Trạng thái kích hoạt
    ];

    // Định nghĩa mối quan hệ: Danh mục con thuộc về một danh mục cha
    public function parent()
    {
        return $this->belongsTo(DanhMucAnh::class, 'parent_id')->withDefault(['name' => '']);
    }

    /**
     * Relationship with images (HinhAnh).
     */
    public function images()
    {
        return $this->hasMany(HinhAnh::class, 'category_child', 'id');
    }

    // Định nghĩa phạm vi: Lọc danh mục con đang kích hoạt
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
}
