<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucTin extends Model
{
    use HasFactory;

    protected $table = 'danhmuctin'; // Đặt tên bảng chính xác ở đây
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
     * Relationship with news (TinTuc).
     */
    public function news()
    {
        return $this->hasMany(TinTuc::class, 'category_id');
    }
}
