<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreferenceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'on_new_mission'    => $this->on_new_mission,
            'on_acceptance'     => $this->on_acceptance,
            'on_refusal'        => $this->on_refusal,
        ];
    }
}
