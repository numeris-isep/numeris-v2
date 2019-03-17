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
        return [
            'project_id'    => 'required|exists:projects,id|integer',
            'title'         => 'required|string',
            'description'   => 'required|string',
            'start_at'      => 'required|date',
            'duration'      => 'required|integer|min:0',
            'capacity'      => 'required|integer|min:0',

            // Address
            'street'        => 'required|string',
            'zip_code'      => 'required|integer',
            'city'          => 'required|string',
        ];
    }
}
