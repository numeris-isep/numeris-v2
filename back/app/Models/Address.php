<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'street',
        'zip_code',
        'city',
    ];

    protected $hidden = [
        'user',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function mission()
    {
        return $this->hasOne(Mission::class);
    }
}
