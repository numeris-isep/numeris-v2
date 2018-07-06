<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        OnEventsTrait;

    protected $fillable = [
        // One-to-One relations
        'address_id',
        'preference_id',

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
        'password',
        'address',
        'preference',
    ];

    protected $casts = [
        'activated'             => 'boolean',
        'tou_accepted'          => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function preference()
    {
        return $this->belongsTo(Preference::class);
    }

    public function setPreference(Preference $preference)
    {
        return $this->preference()->attach($preference);
    }

    /**
     * To be realised just after an user is deleted
     */
    public static function onDeleted(self $user)
    {
        // Delete all related models
        $user->address()->delete();
        $user->preference()->delete();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->using(UserRole::class)
            ->withTimestamps();
    }

    public function setRole(Role $role)
    {
        $this->roles()->attach($role);
    }

    /**
     * Return the current role of the user (= the latest)
     *
     * DISCLAIMER: this method is the corner stone of the website, all user's
     * authorizations depend on it. If it has to be modified, please do it with
     * care. Thanks and happy coding!
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
}
