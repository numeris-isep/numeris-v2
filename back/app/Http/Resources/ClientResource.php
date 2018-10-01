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
            'id'            => $this->id,
            'addressId'    => $this->address_id,
            'name'          => $this->name,
            'reference'     => $this->reference,
            'createdAt'    => $this->created_at->toDateTimeString(),
            'updatedAt'    => $this->updated_at->toDateTimeString(),

            // Relations
            'address'       => $this->whenLoaded('address', AddressResource::make($this->address)),
            'conventions'   => $this->whenLoaded('conventions', ConventionResource::collection($this->conventions)),
        ];
    }
}
