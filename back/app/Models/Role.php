<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'hierarchy',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function isCurrentRole()
    {
        // TODO
    }
}
