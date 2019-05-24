<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RateResource extends JsonResource
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
            'name'          => $this->name,
            'isFlat'        => $this->is_flat,
            'hours'         => $this->when($this->is_flat == true, $this->hours),
            'forStudent'    => $this->for_student,
            'forStaff'      => $this->for_staff,
            'forClient'     => $this->for_client,

            // Relations
            'bills'         => BillResource::collection($this->whenLoaded('bills')),
        ];
    }
}
