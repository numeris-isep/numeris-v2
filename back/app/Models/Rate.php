<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model
{
    public $timestamps = false;

    protected $fillable = [
        // One-to-One
        'convention_id',

        // Attributes
        'name',
        'is_flat',
        'hours',
        'for_student',
        'for_staff',
        'for_client',
    ];

    protected $casts = [
        'is_flat' => 'boolean',
    ];

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    public function convention()
    {
        return $this->belongsTo(Convention::class);
    }
}
