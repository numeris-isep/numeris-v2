<?php

namespace App\Http\Requests;

use App\Models\Rate;

class RateRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $rate = Rate::find($this->route('rate_id'));

        // Use ClientPolicy here to authorize before checking the fields
        if ($current_user->can('store', Rate::class)
            || $current_user->can('update', $rate)
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
            'name'          => 'required|string',
            'is_flat'       => 'required|boolean',
            'hours'         => 'required_if:is_flat,1|numeric|min:0|nullable',
            'for_student'   => 'required|numeric|min:0',
            'for_staff'     => 'required|numeric|min:0',
            'for_client'    => 'required|numeric|min:0',
        ];
    }
}
