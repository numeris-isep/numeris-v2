<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConventionResource extends JsonResource
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
            'name'      => $this->name,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,

            // Relations
            'rates' => RateResource::collection($this->whenLoaded('rates')),
        ];
    }
}
