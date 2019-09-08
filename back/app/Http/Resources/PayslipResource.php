<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PayslipResource extends JsonResource
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
            'id'                            => $this->id,
            'month'                         => $this->month,
            'grossAmount'                   => $this->gross_amount,
            'netAmount'                     => $this->net_amount,
            'finalAmount'                   => $this->final_amount,
            'subscriptionFee'               => $this->subscription_fee,
            'deductionAmount'               => $this->deduction_amount,
            'employerDeductionAmount'       => $this->employer_deduction_amount,
            'deductions'                    => json_decode($this->deductions, true),
            'operations'                    => json_decode($this->operations, true),
            'clients'                       => json_decode($this->clients, true),
            'createdAt'                     => $this->created_at,
            'updatedAt'                     => $this->updated_at,

            // Relations
            'user' => UserResource::make($this->whenLoaded('user')),
        ];
    }
}
