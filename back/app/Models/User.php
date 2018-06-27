<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        // One-to-One relations
        'address_id',

        // attributes
        'activated',
        'tou_accepted',
        'subscription_paid_at',
        'email',
        'password',
        'username',
        'first_name',
        'last_name',
        'student_number',
        'promotion',
        'phone',
        'nationality',
        'birth_date',
        'birth_city',
        'social_insurance_number',
        'iban',
        'bic',
    ];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'activated'             => 'boolean',
        'tou_accepted'          => 'boolean',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function setAddress(Address $address)
    {
        return $this->address()->attach($address);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    /**
     * Return the current role of the user (= the latest)
     */
    public function role()
    {
        return $this->roles()->latest()->first();
    }

    public function isDeveloper()
    {
        return $this->role()->name === "developer";
    }

    public function isAdministrator()
    {
        return $this->role()->name === "administrator";
    }

    public function isStaff()
    {
        return $this->role()->name === "staff";
    }

    public function isStudent()
    {
        return $this->role()->name === "student";
    }

    public function preference()
    {
        return $this->belongsTo(Preference::class);
    }
}
