<?php

namespace App\Http\Controllers;

use App\Http\Requests\MissionRequest;
use App\Http\Resources\MissionResource;
use App\Models\Address;
use App\Models\Mission;
use Illuminate\Http\JsonResponse;

class MissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index()
    {
        $this->authorize('index', Mission::class);

        $this->validate(request(), [
            'page'      => 'integer|min:1',
            'isLocked'  => 'string',
            'from'      => 'date|string',
            'to'        => 'date|string',
        ]);

        $missions = Mission::filtered(
            request()->isLocked,
            [request()->minDate, request()->maxDate]
        )->withCount(['applications' => function($query) {
            return $query->where('status', 'accepted');
        }])->with('address', 'project', 'applications')->paginate(10);

        return MissionResource::collection($missions);
    }

    /**
     * Display a listing of the available missions.
     *
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function indexAvailable()
    {
        $this->authorize('index-available', Mission::class);

        $missions = $missions = Mission::available()->sortBy('start_at');

        return response()->json(MissionResource::collection(
            $missions->load('address', 'project', 'applications')
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MissionRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(MissionRequest $request)
    {
        $this->authorize('store', Mission::class);

        $mission_request = $request->except([
            'street', 'zip_code', 'city'
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $mission = Mission::create($mission_request);
        $address = Address::create($address_request);
        $address->mission()->save($mission);

        return response()->json(new MissionResource($mission), JsonResponse::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param $mission_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('show', $mission);

        $mission->load(['address', 'project', 'applications']);

        return response()->json(MissionResource::make($mission));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MissionRequest $request
     * @param $mission_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(MissionRequest $request, $mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('update', $mission);

        $mission_request = $request->except([
            'street', 'zip_code', 'city'
        ]);
        $address_request = $request->only([
            'street', 'zip_code', 'city',
        ]);

        $mission->update($mission_request);
        $mission->address()->update($address_request);

        return response()->json(MissionResource::make($mission), JsonResponse::HTTP_CREATED);
    }

    /**
     * Update the mission lock status resource in storage.
     *
     * @param MissionRequest $request
     * @param $mission_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateLock(MissionRequest $request, $mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('update-lock', $mission);

        $mission->update($request->only(['is_locked']));

        return response()->json(MissionResource::make($mission), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $mission_id
     * @return JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($mission_id)
    {
        $mission = Mission::findOrFail($mission_id);
        $this->authorize('destroy', $mission);

        $mission->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
