<?php

namespace App\Http\Requests;

use App\Models\Convention;

class ConventionRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $convention = Convention::find($this->route('convention_id'));

        // Use ClientPolicy here to authorize before checking the fields
        return $current_user->can('store', Convention::class)
            || $current_user->can('update', $convention);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_id'             => 'required|integer|exists:clients,id',
            'name'                  => 'required|string',
            'rates'                 => 'required|array|min:1',
            'rates.*.name'          => 'required|distinct|string',
            'rates.*.for_student'   => 'required|numeric|min:0',
            'rates.*.for_staff'     => 'required|numeric|min:0',
            'rates.*.for_client'    => 'required|numeric|min:0',
            'rates.*.is_flat'       => 'required|boolean',
            'rates.*.hours'         => 'required_if:rates.*.is_flat,true|numeric|min:0|nullable',
        ];
    }
}
