<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'activated',
        'tou_accepted',
        'membership_fee_paid',
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
        'remember_token',
    ];

    protected $casts = [
        'activated'             => 'boolean',
        'tou_accepted'          => 'boolean',
        'membership_fee_paid'   => 'boolean',
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
        return $this->hasOne(Address::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->withTimestamps();
    }

    public function currentRole()
    {
        return $this->roles()->latest()->first();
    }

    public function isDeveloper()
    {
        return $this->currentRole()->name === "developer";
    }

    public function isAdministrator()
    {
        return $this->currentRole()->name === "administrator";
    }

    public function isStaff()
    {
        return $this->currentRole()->name === "staff";
    }

    public function isStudent()
    {
        return $this->currentRole()->name === "student";
    }

    public function notifs()
    {
        return $this->hasOne(Notification::class);
    }
}
