<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index($client_id)
    {
        $client = Client::findOrFail($client_id);
        $this->authorize('index', Project::class);

        $this->validate(request(), [
            'page'      => 'integer|min:1',
            'status'    => 'string|in:' . implode(',', Project::steps()),
            'from'      => 'date|string',
            'to'        => 'date|string',
        ]);

        $projects = Project::filtered(
            request()->step,
            [request()->minDate, request()->maxDate],
            $client->id
        )->withCount('missions')->with('client')->paginate(10);

        return ProjectResource::collection($projects);
    }
}
