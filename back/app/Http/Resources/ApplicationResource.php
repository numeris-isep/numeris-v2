<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
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
            'id'        => $this->id,
            'userId'    => $this->user_id,
            'missionId' => $this->mission_id,
            'type'      => $this->type,
            'status'    => $this->status,
            'createdAt' => $this->created_at->toDateTimeString(),
            'updatedAt' => $this->updated_at->toDateTimeString(),

            // Relations
            'user'      => UserResource::make($this->whenLoaded('user')),
            'mission'   => MissionResource::make($this->whenLoaded('mission')),
        ];
    }
}
