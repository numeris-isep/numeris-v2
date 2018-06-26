<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'street',
        'postcode',
        'city',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
