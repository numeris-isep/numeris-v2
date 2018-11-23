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
            'onNewMission'      => $this->on_new_mission,
            'onAcceptance'      => $this->on_acceptance,
            'onRefusal'         => $this->on_refusal,
            'onDocument'        => $this->on_document,
            'byEmail'           => $this->by_email,
            'byPush'            => $this->by_push
        ];
    }
}
