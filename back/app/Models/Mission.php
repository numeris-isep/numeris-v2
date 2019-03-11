<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use OnEventsTrait;

    protected $fillable = [
        // One-to-One relations
        'address_id',
        'project_id',

        // Attributes
        'title',
        'description',
        'start_at',
        'duration',
        'capacity',
    ];

    protected $hidden = [
        'project',
        'client',
        'address',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function client()
    {
        return $this->project->client();
    }

    /**
     * To be realised just after an mission is deleted
     */
    public static function onDeleted(self $mission)
    {
        // Delete all related models
        $mission->address()->delete();
    }
}
