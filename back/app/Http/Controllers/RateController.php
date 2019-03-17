<?php

namespace App\Http\Controllers;

use App\Http\Requests\RateRequest;
use App\Http\Resources\RateResource;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;

class RateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RateRequest $request, $rate_id)
    {
        $rate = Rate::findOrFail($rate_id);
        $this->authorize('update', $rate);

        $rate->update($request->all());

        return response()->json(RateResource::make($rate), JsonResponse::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($rate_id)
    {
        $rate = Rate::findOrFail($rate_id);
        $this->authorize('destroy', $rate);

        $rate->delete();

        return response()->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
