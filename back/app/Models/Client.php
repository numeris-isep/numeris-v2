<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use OnEventsTrait;

    protected $fillable = [
        // One-to-One relations
        'address_id',

        // attributes
        'name',
        'reference',
    ];

    protected $hidden = [
        'address',
        'projects',
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
}
