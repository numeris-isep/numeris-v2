<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public $timestamps = false;

    protected $fillable = [
        // One-to-Many
        'rate_id',
        'application_id',

        // Attributes
        'amount',
    ];

    public function application() {
        return $this->belongsToMany(Application::class);
    }

    public function rate() {
        return $this->belongsToMany(Rate::class);
    }
}
