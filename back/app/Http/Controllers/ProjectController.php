<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', Project::class);

        return response()->json(ProjectResource::collection(Project::all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProjectRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ProjectRequest $request)
    {
        $this->authorize('store', Project::class);

        $project = Project::create(array_merge($request->all(), ['step' => Project::HIRING]));

        return response()->json(new ProjectResource($project), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $project_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('show', $project);

        $project->load(['client', 'convention']);

        return response()->json(ProjectResource::make($project));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProjectRequest $request
     * @param $project_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ProjectRequest $request, $project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('update', $project);

        $project->update($request->all());

        return response()->json(ProjectResource::make($project), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $project_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($project_id)
    {
        $project = Project::findOrFail($project_id);
        $this->authorize('destroy', $project);

        // DISCLAIMER: The following line removes the project as well as its
        // related missions
        $project->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
