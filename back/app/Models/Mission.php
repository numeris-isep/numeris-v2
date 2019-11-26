<?php

namespace App\Models;

use App\Models\Traits\OnEventsTrait;
use App\Models\Traits\DateQueryTrait;
use App\Notifications\PreMissionNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Mission extends Model
{
    use OnEventsTrait,
        DateQueryTrait,
        Notifiable;

    protected $fillable = [
        // One-to-One relations
        'address_id',
        'project_id',
        'user_id',
        'contact_id',

        // Attributes
        'is_locked',
        'reference',
        'title',
        'description',
        'start_at',
        'duration',
        'capacity',
    ];

    protected $hidden = [
        'address',
        'client',
        'user',
        'contact',
        'project',
        'applications',
    ];

    protected $casts = [
        'is_locked' => 'boolean',
    ];

    public static function findByTitle($title)
    {
        return static::where('title', $title)->first();
    }

    public static function opened()
    {
        return static::query()
            ->where('is_locked', false);
    }

    public static function locked()
    {
        return static::query()
            ->where('is_locked', true);
    }

    public static function available(User $user = null)
    {
        $user = $user ?: auth()->user();

        return static::opened()
            ->whereDate('start_at', '>', now())
            ->get()
            ->filter(function($mission) use ($user) {
                if ($mission->project->is_private && ! $mission->project->hasUser($user)) {
                    return null;
                }
                return $mission->project->step == Project::HIRING ? $mission : null;
            });
    }

    public static function filtered($is_locked, array $range, $project_id = null)
    {
        return static::whereDate('start_at', $range)
            ->when($is_locked != null, function ($query) use ($is_locked) {
                return $query->where('is_locked', $is_locked === 'true' ? true : false);
            })->when($project_id != null, function ($query) use ($project_id) {
                return $query->where('project_id', $project_id);
            });
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class)->with('client');
    }

    public static function findByProject($project_id)
    {
        return Project::find($project_id)->missions;
    }

    public static function findByProjectName($project_name)
    {
        return Project::findByName($project_name)->missions;
    }

    public static function findByClient($client_id)
    {
        return Client::find($client_id)->missions;
    }

    public static function findByClientName($client_name)
    {
        return Client::findByName($client_name)->missions;
    }

    public function generateReference()
    {
        $this->reference = $this->project->convention->name
            . '-' . strtoupper(substr(sha1(bin2hex(random_bytes(16))), 0, 4));
    }

    /**
     * To be realised just after an mission is deleted
     */
    public static function onDeleted(self $mission)
    {
        // Delete all related models
        $mission->address()->delete();
    }

    public static function onSaving(self $mission)
    {
        $mission->generateReference();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function applicationsWhoseStatusIs($status =  null)
    {
        return $this->hasMany(Application::class)
            ->when($status, function ($query) use ($status) {
                return $query->where('status', '=', $status);
            })->get();
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

    public static function withApplicationsCounts()
    {
        return static::withCount([
            'applications',
            'applications as waiting_applications_count' => function($query) {
                $query->where('status', '=', Application::WAITING);
            },
            'applications as accepted_applications_count' => function($query) {
                $query->where('status', '=', Application::ACCEPTED);
            },
            'applications as refused_applications_count' => function($query) {
                $query->where('status', '=', Application::REFUSED);
            },
        ]);
    }

    public function users()
    {
        return $this->applications->map(function($a) {
            return $a->user;
        });
    }

    public function bills()
    {
        return $this->hasManyThrough(
            Bill::class,
            Application::class,
            'mission_id',
            'application_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function sendPreMissionNotification(string $subject, string $content)
    {
        $this->notify(new PreMissionNotification($this, $subject, $content));
    }
}
