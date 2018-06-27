<?php

namespace App\Http\Requests;

class AddressRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'street'    => 'required|string',
            'zip_code'  => 'required|integer',
            'city'      => 'required|string',
        ];
    }
}
