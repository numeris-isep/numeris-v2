<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Address extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'street',
        'zip_code',
        'city',
    ];

    protected $hidden = [
        'user',
    ];

    public function getFullAddress()
    {
        return sprintf(
            '%s %s %s',
            $this->street,
            $this->zip_code,
            $this->city
        );
    }

    public function user()
    {
        return $this->hasOne(User::class)
            ->withoutGlobalScope(SoftDeletingScope::class);
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function mission()
    {
        return $this->hasOne(Mission::class);
    }
}
