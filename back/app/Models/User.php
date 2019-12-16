<?php

namespace App\Models;

use App\Models\Traits\OnEventsTrait;
use App\Notifications\ActivateUserNotification;
use App\Notifications\ApplicationNotification;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\ProjectUser;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable,
        OnEventsTrait,
        SoftDeletes;

    protected $fillable = [
        // One-to-One relations
        'address_id',
        'preference_id',

        // attributes
        'activated',
        'tou_accepted',
        'email_verified_at',
        'subscription_paid_at',
        'email',
        'password',
        'first_name',
        'last_name',
        'student_number',
        'promotion',
        'school_year',
        'phone',
        'nationality',
        'birth_date',
        'birth_city',
        'social_insurance_number',
        'iban',
        'bic',
        'deleted_at',
    ];

    protected $hidden = [
        'password',
        'address',
        'preference',
        'applications',
    ];

    protected $casts = [
        'activated'     => 'boolean',
        'tou_accepted'  => 'boolean',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getFullName()
    {
        return sprintf(
            '%s %s',
            $this->first_name,
            strtoupper($this->last_name)
        );
    }

    public static function findByEmail($email)
    {
        return static::where('email', $email)->first();
    }

    public static function filtered($search, $role, $promotion, $project_id = null, $in_project = null, $only_active = true) {
        return static::when($only_active, function ($query) use ($only_active) {
            return $query->where('activated', true);
        })
            ->when($search != null, function($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    return $query->where('first_name', 'LIKE', "%{$search}%")
                        ->orWhere('last_name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                });
            })
            ->when($promotion != null, function ($query) use ($promotion) {
                return $query->where('promotion', $promotion);
            })->when($project_id != null, function ($query) use ($project_id, $in_project) {
                if (!$in_project) {
                    return $query->whereHas('projects', function($query) use ($project_id) {
                        return $query->where('project_id', $project_id);
                    });
                } else {
                    return $query->whereDoesntHave('projects', function($query) use ($project_id) {
                        return $query->where('project_id', $project_id);
                    });
                }
            })
            ->get()
            ->when($role != null, function($query) use ($role) {
                return $query->filter(function($user) use ($role) {
                    return $user->role()->name == $role;
                });
            });
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
        return $this->preference()->associate($preference);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)
            ->using(UserRole::class)
            ->orderBy('role_user.created_at', 'DESC') // IMPORTANT
            ->withTimestamps();
    }

    public function setRole(Role $role)
    {
        $this->roles()->attach($role);
    }

    /**
     * Returns the current role of the user (= the latest)
     *
     * DISCLAIMER: this method is the corner stone of the website, all user's
     * authorizations depend on it. If it has to be modified, please do it with
     * care.
     */
    public function role()
    {
        return $this->roles()->latest()->first();
    }

    /**
     * Returns the role of the user at a given date
     */
    public function roleAt(string $date)
    {
        return $this->roles
            ->filter(function (Role $role) use ($date) {
                return $role->pivot
                    ->created_at
                    ->isBefore(Carbon::parse($date));
            })->first();
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

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function appliedMissions()
    {
        return $this->applications()
            ->with('mission')->get()
            ->pluck('mission')->flatten();
    }

    public function hasAppliedTo(Mission $mission)
    {
        return $this->appliedMissions()->contains($mission);
    }

    public function waitingApplications()
    {
        return $this->applications()
            ->where('status','=', Application::WAITING);
    }

    public function acceptedApplications()
    {
        return $this->applications()
            ->where('status','=', Application::ACCEPTED);
    }

    public function refusedApplications()
    {
        return $this->applications()
            ->where('status','=', Application::REFUSED);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class)
            ->using(ProjectUser::class);
    }

    public function belongsToProject(Project $project)
    {
        return $project->hasUser($this);
    }

    public function payslips()
    {
        return $this->hasMany(Payslip::class)
            ->orderBy('month', 'asc');
    }

    public static function active()
    {
        return static::where('activated', true)->get();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function sendActivateUserNotification()
    {
        $this->notify(new ActivateUserNotification());
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification());
    }

    public function sendApplicationNotification(Application $application)
    {
        if (in_array($application->status, [Application::ACCEPTED, Application::REFUSED])) {
            $attribute = Preference::statusToAttribute()[$application->status];

            if ($this->preference->$attribute) {
                $this->notify(new ApplicationNotification($application));
            }
        }
    }
}
