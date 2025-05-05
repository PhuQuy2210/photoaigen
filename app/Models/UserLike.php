<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLike extends Model
{
    use HasFactory;
    public $timestamps = false; // Tắt tính năng timestamps

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'hinhanh_id',
        'liked_at',
    ];

    /**
     * Relationship with user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with image (hinhanh).
     */
    public function image()
    {
        return $this->belongsTo(HinhAnh::class, 'hinhanh_id');
    }
}
