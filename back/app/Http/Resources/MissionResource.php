<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MissionResource extends JsonResource
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
            'id'            => $this->id,
            'title'         => $this->title,
            'description'   => $this->description,
            'startAt'       => $this->start_at,
            'duration'      => $this->duration,
            'capacity'      => $this->capacity,

            // Relations
            'address'       => $this->whenLoaded('address', AddressResource::make($this->address)),
            'project'       => $this->whenLoaded('project', ProjectResource::make($this->project))
        ];
    }
}
