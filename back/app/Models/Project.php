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

    private static $steps = [
        self::HIRING,
        self::VALIDATED,
        self::BILLED,
        self::PAID,
        self::CLOSED,
    ];

    protected $fillable = [
        // One-to-One relations
        'client_id',
        'convention_id',

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

    public function convention()
    {
        return $this->belongsTo(Convention::class);
    }

    public function missions()
    {
        return $this->hasMany(Mission::class);
    }
}
