<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
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
            'addressId'         => $this->address_id,
            'contactId'         => $this->contact_id,
            'name'              => $this->name,
            'reference'         => $this->reference,
            'createdAt'         => $this->created_at->toDateTimeString(),
            'updatedAt'         => $this->updated_at->toDateTimeString(),

            // Counts
            'conventionsCount'  => $this->conventions_count,
            'projectsCount'     => $this->projects_count,
            'missionsCount'     => $this->missions_count,

            // Relations
            'address'           => AddressResource::make($this->whenLoaded('address')),
            'contact'           => ContactResource::make($this->whenLoaded('contact')),
            'conventions'       => ConventionResource::collection($this->whenLoaded('conventions')),
            'projects'          => ProjectResource::collection($this->whenLoaded('projects')),
            'missions'          => MissionResource::collection($this->whenLoaded('missions')),
        ];
    }
}
