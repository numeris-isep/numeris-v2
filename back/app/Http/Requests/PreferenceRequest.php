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
        $preference = Preference::findOrFail($this->route('preference_id'));

        // Use PreferencePolicy here to authorize before checking the fields
        return $current_user->can('update', $preference);
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
            'on_document'       => 'required|boolean',
        ];
    }
}
