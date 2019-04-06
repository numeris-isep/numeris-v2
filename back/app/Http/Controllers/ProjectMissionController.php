<?php

namespace App\Http\Controllers;

use App\Http\Resources\MissionResource;
use App\Models\Mission;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectMissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index($project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('index', Mission::class);

        $this->validate(request(), [
            'page'      => 'integer|min:1',
            'isLocked'  => 'string',
            'from'      => 'date|string',
            'to'        => 'date|string',
        ]);

        $missions = Mission::filtered(
            request()->isLocked,
            [request()->minDate, request()->maxDate],
            $project->id
        )->withCount(['applications' => function($query) {
            return $query->where('status', 'accepted');
        }])->with('project', 'applications')->paginate(10);

        return MissionResource::collection($missions);
    }
}
