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
            'id'                        => $this->id,
            'preference_id'             => $this->preference_id,
            'address_id'                => $this->address_id,
            'activated'                 => $this->activated,
            'tou_accepted'              => $this->tou_accepted,
            'subscription_paid_at'      => $this->subscription_paid_at,
            'email'                     => $this->email,
            'username'                  => $this->username,
            'first_name'                => $this->first_name,
            'last_name'                 => $this->last_name,
            'student_number'            => $this->student_number,
            'promotion'                 => $this->promotion,
            'phone'                     => $this->phone,
            'nationality'               => $this->nationality,
            'birth_date'                => $this->birth_date,
            'birth_city'                => $this->birth_city,
            'social_insurance_number'   => $this->social_insurance_number,
            'iban'                      => $this->iban,
            'bic'                       => $this->bic,
            'created_at'                => $this->created_at->toDateTimeString(),
            'updated_at'                => $this->updated_at->toDateTimeString(),

            // Relation
            'address'                   => $this->whenLoaded('address', AddressResource::make($this->address)),
            'preference'                => $this->whenLoaded('preference', PreferenceResource::make($this->preference)),
            'role'                      => $this->whenLoaded('roles', UserRoleResource::make($this->role())),
        ];
    }
}
