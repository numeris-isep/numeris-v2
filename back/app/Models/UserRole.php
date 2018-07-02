<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = 'role_user';
    
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function findByUser($user_id)
    {
        return static::where('user_id', $user_id)->get();
    }
}
