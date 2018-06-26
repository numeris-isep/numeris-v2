<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'on_new_mission',
        'on_acceptance',
        'on_refusal',
    ];

    protected $casts = [
        'on_new_mission'    => 'boolean',
        'on_acceptance'     => 'boolean',
        'on_refusal'        => 'boolean',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
