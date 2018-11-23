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
            'subscriptionPaidAt'    => $this->subscription_paid_at,
            'email'                 => $this->email,
            'username'              => $this->username,
            'firstName'             => $this->first_name,
            'lastName'              => $this->last_name,
            'studentNumber'         => $this->student_number,
            'promotion'             => $this->promotion,
            'schoolYear'            => $this->school_year,
            'phone'                 => $this->phone,
            'nationality'           => $this->nationality,
            'birthDate'             => $this->birth_date,
            'birthCity'             => $this->birth_city,
            'socialInsuranceNumber' => $this->social_insurance_number,
            'iban'                  => $this->iban,
            'bic'                   => $this->bic,
            'createdAt'             => $this->created_at->toDateTimeString(),
            'updatedAt'             => $this->updated_at->toDateTimeString(),

            // Relation
            'address'               => $this->whenLoaded('address', AddressResource::make($this->address)),
            'preference'            => $this->whenLoaded('preference', PreferenceResource::make($this->preference)),
            'role'                  => $this->whenLoaded('roles', UserRoleResource::make($this->role())),
        ];
    }
}
