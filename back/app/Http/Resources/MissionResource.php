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
            'id'                    => $this->id,
            'isLocked'              => $this->is_locked,
            'reference'             => $this->reference,
            'title'                 => $this->title,
            'description'           => $this->description,
            'startAt'               => $this->start_at,
            'duration'              => $this->duration,
            'capacity'              => $this->capacity,

            // Count
            'applications_count'    => $this->applications_count,

            // Relations
            'address'               => AddressResource::make($this->whenLoaded('address')),
            'project'               => ProjectResource::make($this->whenLoaded('project')),
            'applications'          => ApplicationResource::collection($this->whenLoaded('applications')),
        ];
    }
}
