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
            'startAt'           => $this->start_at,
            'isPrivate'         => $this->is_private,
            'moneyReceivedAt'   => $this->money_received_at,
            'createdAt'         => $this->created_at->toDateTimeString(),
            'updatedAt'         => $this->updated_at->toDateTimeString(),

            // Relations
            'client'            => $this->whenLoaded('client', ClientResource::make($this->client)),
        ];
    }
}
