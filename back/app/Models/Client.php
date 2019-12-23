<?php

namespace App\Models;

use App\Models\Traits\OnEventsTrait;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use OnEventsTrait;

    protected $fillable = [
        // One-to-One relations
        'address_id',
        'contact_id',

        // attributes
        'name',
        'time_limit',
    ];

    protected $hidden = [
        'address',
        'projects',
        'conventions',
        'missions',
    ];

    public static function findByName($name)
    {
        return static::where('name', $name)->first();
    }

    /**
     * To be realised just before a client is deleted
     */
    public static function onDeleting(self $client)
    {
        // Delete all related models
        $client->projects()->delete();
    }

    /**
     * To be realised just after a client is deleted
     */
    public static function onDeleted(self $client)
    {
        // Delete all related models
        $client->address()->delete();
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function conventions()
    {
        return $this->hasMany(Convention::class)
            ->orderBy('created_at', 'DESC');
    }

    public function missions()
    {
        return $this->hasManyThrough(
            Mission::class,
            Project::class,
            'client_id',
            'project_id'
        );
    }

    public function invoices()
    {
        return $this->hasManyThrough(
            Invoice::class,
            Project::class,
            'client_id',
            'project_id'
        );
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function bills()
    {
        $bills = collect();

        foreach ($this->projects as $project) {
            $project_bills = $project->bills();

            if ($project_bills->count()) {
                $bills = $bills->merge($project_bills);
            }
        }

        return $bills;
    }
}
