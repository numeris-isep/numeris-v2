<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    const USER_APPLICATION = 'user-application';

    const STAFF_PLACEMENT = 'staff-placement';

    private static $types = [
        self::USER_APPLICATION,
        self::STAFF_PLACEMENT,
    ];

    const WAITING = 'waiting';

    const ACCEPTED = 'accepted';

    const REFUSED = 'refused';

    private static $statutes = [
        self::WAITING,
        self::ACCEPTED,
        self::REFUSED,
    ];

    protected $fillable = [
        'type',
        'status',
    ];

    protected $hidden = [
        'user',
        'mission',
    ];

    public static function types()
    {
        return static::$types;
    }

    public static function statutes()
    {
        return static::$statutes;
    }

    public function mission()
    {
        return $this->belongsTo(Mission::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
