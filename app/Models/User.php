<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'facebook_account_id',
        'google_account_id',
        'role_id',
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token', // Token để ghi nhớ đăng nhập
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship with roles.
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    /**
     * Relationship with user_likes.
     */
    public function likes()
    {
        return $this->hasMany(UserLike::class);
    }

    /**
     * Relationship with blogs.
     */
    public function blogs()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relationship with social accounts.
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    //Mối quan hệ với Bản Báo cáo
    public function baocaos()
    {
        return $this->hasMany(BaoCao::class, 'user_id');
    }

    
}
