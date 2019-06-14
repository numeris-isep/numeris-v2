<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            'id'        => $this->id,
            'name'      => $this->name,
            'nameFr'    => $this->name_fr,
            'hierarchy' => $this->when(
                auth()->user()->role()->name === Role::DEVELOPER,
                $this->hierarchy
            ),
        ];
    }
}
