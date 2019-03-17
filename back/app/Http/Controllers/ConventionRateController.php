<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Http\Resources\ConventionResource;
use App\Http\Resources\RateResource;
use App\Models\Convention;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;

class ConventionRateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RateRequest $request, $convention_id)
    {
        $convention = Convention::findOrFail($convention_id);
        $this->authorize('store', Rate::class);

        $rate = Rate::create($request->all());
        $convention->rates()->save($rate);

        return response()->json(RateResource::make($rate), JsonResponse::HTTP_CREATED);
    }
}
