<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserRoleResource extends JsonResource
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
            'hierarchy' => $this->when(
                auth()->user()->role()->name === 'developer',
                $this->hierarchy
            ),
            'createdAt' => $this->whenPivotLoaded($this->pivot, $this->pivot->created_at->toDateTimeString()),
        ];
    }
}
