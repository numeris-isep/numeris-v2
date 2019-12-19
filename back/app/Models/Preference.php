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
        'on_document',
    ];

    protected static $statusToAttribute = [
        'accepted'  => 'on_acceptance',
        'refused'   => 'on_refusal',
    ];

    protected $casts = [
        'on_new_mission'    => 'boolean',
        'on_acceptance'     => 'boolean',
        'on_refusal'        => 'boolean',
        'on_document'       => 'boolean',
    ];

    protected $hidden = [
        'user',
    ];

    public static function statusToAttribute()
    {
        return self::$statusToAttribute;
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public static function init()
    {
        return static::create([
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => false,
            'on_document'       => true,
        ]);
    }
}
