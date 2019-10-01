<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'preferenceId'          => $this->preference_id,
            'addressId'             => $this->address_id,
            'activated'             => $this->activated,
            'touAccepted'           => $this->tou_accepted,
            'emailVerifiedAt'       => $this->email_verified_at,
            'subscriptionPaidAt'    => $this->subscription_paid_at,
            'email'                 => $this->email,
            'firstName'             => $this->first_name,
            'lastName'              => $this->last_name,
            'promotion'             => $this->promotion,
            'phone'                 => $this->phone,
            'nationality'           => $this->nationality,
            'birthDate'             => $this->birth_date,
            'birthCity'             => $this->birth_city,
            'socialInsuranceNumber' => $this->social_insurance_number,
            'iban'                  => $this->iban,
            'bic'                   => $this->bic,
            'createdAt'             => $this->created_at->toDateTimeString(),
            'updatedAt'             => $this->updated_at->toDateTimeString(),

            // Relations
            'address'               => AddressResource::make($this->whenLoaded('address')),
            'preference'            => PreferenceResource::make($this->whenLoaded('preference')),
            'roles'                 => UserRoleResource::collection($this->whenLoaded('roles')),
            'payslips'              => PayslipResource::collection($this->whenLoaded('payslips')),
        ];
    }
}
