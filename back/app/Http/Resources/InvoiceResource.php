<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'grossAmount'   => $this->gross_amount,
            'hourAmount'    => $this->hour_amount,
            'vatAmount'     => $this->vat_amount,
            'finalAmount'   => $this->final_amount,
            'timeLimit'     => $this->time_limit,
            'details'       => json_decode($this->details, true),
            'createdAt'     => $this->created_at,
            'updatedAt'     => $this->updated_at,

            // Relation
            'project'       => ProjectResource::make($this->whenLoaded('project')),
        ];
    }
}
