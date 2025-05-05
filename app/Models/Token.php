<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'token',
        'token_type',
        'expiration_date',
        'revoked',
        'expired',
        'user_id',
    ];

    /**
     * Relationship with the user (User).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Checks if the token is valid (not expired and not revoked).
     *
     * @return bool
     */
    public function isValid()
    {
        return !$this->revoked && !$this->expired && $this->expiration_date > now();
    }
}
