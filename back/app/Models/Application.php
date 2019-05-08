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

    private static $statuses = [
        self::WAITING,
        self::ACCEPTED,
        self::REFUSED,
    ];

    private static $statusTranslations = [
        [
            'status'            => self::WAITING,
            'translation'       => 'en attente',
            'translationPlural' => 'en attente',
        ],
        [
            'status'            => self::ACCEPTED,
            'translation'       => 'acceptée',
            'translationPlural' => 'acceptées',
        ],
        [
            'status'            => self::REFUSED,
            'translation'       => 'refusée',
            'translationPlural' => 'refusées',
        ],
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

    public static function statuses()
    {
        return static::$statuses;
    }

    public static function statusTranslations()
    {
        return static::$statusTranslations;
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
