<?php

namespace App\Models;

use App\Models\Traits\DateQueryTrait;
use App\ProjectUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Project extends Model
{
    use DateQueryTrait;

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

    private static $stepTranslations = [
        ['step' => self::HIRING,    'translation' => 'Ouvert'],
        ['step' => self::VALIDATED, 'translation' => 'Validé'],
        ['step' => self::BILLED,    'translation' => 'Facturé'],
        ['step' => self::PAID,      'translation' => 'Payé'],
        ['step' => self::CLOSED,    'translation' => 'Cloturé'],
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
        'convention',
        'missions',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public static function steps()
    {
        return static::$steps;
    }

    public static function stepTranslations()
    {
        return static::$stepTranslations;
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

    public static function findByMonth(string $month)
    {
        $from = Carbon::parse($month);
        $to = $from->copy()->addMonth();

        return static::where('start_at', '>=', $from->toDateString())
            ->where('start_at', '<', $to->toDateString())
            ->get();
    }

    public static function public()
    {
        return static::where('is_private', false);
    }

    public static function private()
    {
        return static::where('is_private', true);
    }

    public static function filtered($step, array $range, $client_id = null) {
        return static::whereDate('start_at', $range)
            ->when($step != null, function($query) use ($step) {
                return $query->where('step', $step);
            })->when($client_id != null, function ($query) use ($client_id) {
                return $query->where('client_id', $client_id);
            });
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

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->using(ProjectUser::class)
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function hasUser(User $user)
    {
        return $this->users->contains($user);
    }

    public function addUser(User $user)
    {
        $this->users()->attach($user);
    }

    public function removeUser(User $user)
    {
        $this->users()->detach($user);
    }

    public function bills()
    {
        $bills = collect();

        foreach ($this->missions as $mission) {
            $mission_bills = $mission->bills;

            if ($mission_bills->count()) {
                $bills = $bills->merge($mission_bills);
            }
        }

        return $bills;
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }
}
