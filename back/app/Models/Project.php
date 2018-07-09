<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Project extends Model
{
    const HIRING = 'hiring';

    const VALIDATED = 'validated';

    const BILLED = 'billed';

    const PAID = 'paid';

    const CLOSED = 'closed';

    protected $fillable = [
        // One-to-One relations
        'client_id',
//        'convention_id', TODO

        // attributes
        'name',
        'step',
        'start_at',
        'is_private',
        'money_received_at',
    ];

    protected $hidden = [
        'client',
    ];

    private static $steps = [
        self::HIRING,
        self::VALIDATED,
        self::BILLED,
        self::PAID,
        self::CLOSED,
    ];

    public static function steps()
    {
        return static::$steps;
    }

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    public static function findByStep($step)
    {
        if (in_array($step, static::$steps)) {
            return static::where('step', $step)->get();
        }

        throw new ModelNotFoundException();
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
