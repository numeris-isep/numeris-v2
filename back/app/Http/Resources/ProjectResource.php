<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'name'              => $this->name,
            'step'              => $this->step,
            'start_at'          => $this->start_at,
            'is_private'        => $this->is_private,
            'money_received_at' => $this->money_received_at,

            // Relations
            'client'            => $this->whenLoaded('client', ClientResource::make($this->client)),
        ];
    }
}
