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
    ];

    /**
     * To be realised just after an user is deleted
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
}
