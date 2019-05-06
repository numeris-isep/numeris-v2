<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        // One-to-one relations
        'client_id',

        // Attributes
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    protected $hidden = [
        'client'
    ];

    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
