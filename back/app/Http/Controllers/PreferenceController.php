<?php

namespace App\Http\Controllers;

use App\Http\Requests\PreferenceRequest;
use App\Http\Resources\PreferenceResource;
use App\Models\Preference;
use Illuminate\Http\JsonResponse;

class PreferenceController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PreferenceRequest $request, $preference_id)
    {
        $preference = Preference::findOrFail($preference_id);
        $this->authorize('update', $preference);

        $preference->update($request->all());

        return response()->json(PreferenceResource::make($preference), JsonResponse::HTTP_CREATED);
    }
}
