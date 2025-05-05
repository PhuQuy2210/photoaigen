<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $table = 'social_accounts';

    protected $fillable = [
        'provider',
        'provider_id',
        'email',
        'name',
        'avatar_url',
        'user_id',
    ];

    public $timestamps = false;

    // Quan hệ ngược với bảng users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
