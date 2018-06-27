<?php

namespace App\Http\Requests;

use App\Models\Address;

class AddressRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $address = Address::find($this->route('user_id'));

        // Use AddressPolicy here to authorize before checking the fields
        if ($current_user->can('store', Address::class)
            || $current_user->can('update', $address)
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
            'street'    => 'required|string',
            'zip_code'  => 'required|integer',
            'city'      => 'required|string',
        ];
    }
}
