<?php

namespace App\Http\Requests;

use App\Models\Preference;

class PreferenceRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $preference = Preference::find($this->route('user_id'));

        // Use PreferencePolicy here to authorize before checking the fields
        if ($current_user->can('store', Preference::class)
            || $current_user->can('update', $preference)
        ) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'on_new_mission'    => 'required|boolean',
            'on_acceptance'     => 'required|boolean',
            'on_refusal'        => 'required|boolean',
        ];
    }
}
