<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialContribution extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'student_rate',
        'employer_rate',
        'base',
    ];

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }
}
