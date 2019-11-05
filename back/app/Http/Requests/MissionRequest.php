<?php

namespace App\Http\Requests;

use App\Models\Mission;

class MissionRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $mission = Mission::find($this->route('mission_id'));

        // Use MissionPolicy here to authorize before checking the fields
        return $current_user->can('store', Mission::class)
            || $current_user->can('update', $mission);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method())
        {
            case 'PATCH':
                return [
                    'is_locked' => 'required|boolean'
                ];
            default: break;
        }


        return [
            'project_id'    => 'required|exists:projects,id|integer',
            'user_id'       => 'required|exists:users,id|integer',
            'contact_id'    => 'exists:contacts,id|integer',
            'title'         => 'required|string',
            'description'   => 'required|string',
            'start_at'      => 'required|date',
            'duration'      => 'required|numeric|min:0',
            'capacity'      => 'required|integer|min:0',

            // Address
            'address.street'        => 'required|string',
            'address.zip_code'      => 'required|integer',
            'address.city'          => 'required|string',
        ];
    }
}
