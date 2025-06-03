<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Prunable;

class Session extends Model
{
    use Prunable;

    protected $table = 'sessions';

    public function prunable()
    {
        return static::where('last_activity', '<', now()->subMinutes(config('session.lifetime'))->getTimestamp());
    }
}
