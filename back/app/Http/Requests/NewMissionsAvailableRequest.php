<?php

namespace App\Http\Requests;

use App\Models\Mission;

class NewMissionsAvailableRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('notify-availability', Mission::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get available public missions
        $missions = Mission::all()->filter(function (Mission $mission) {
            return ! $mission->isPrivate;
        })->pluck('id')->toArray();

        return [
            'missions'      => 'required|array',
            'missions.*'    => 'in:' . implode(',', $missions),
        ];
    }
}
