<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BillResource extends JsonResource
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
            'applicationId' => $this->application_id,
            'rateId'       => $this->rate_id,
            'amount'        => $this->amount,

            // Relations
            'application'   => ApplicationResource::make($this->whenLoaded('application')),
            'rate'          => ApplicationResource::make($this->whenLoaded('rate')),
        ];
    }
}
