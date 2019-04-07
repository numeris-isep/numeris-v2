<?php

namespace App\Models;

use App\Models\Traits\OnEventsTrait;
use App\Models\Traits\DateQueryTrait;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use OnEventsTrait,
        DateQueryTrait;

    protected $fillable = [
        // One-to-One relations
        'address_id',
        'project_id',

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
                if ($mission->project->is_private) {
                    return $mission->project->hasUser($user) ? $mission : null;
                }

                return $mission;
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

    /**
     * To be realised just after an mission is deleted
     */
    public static function onDeleted(self $mission)
    {
        // Delete all related models
        $mission->address()->delete();
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
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
}
