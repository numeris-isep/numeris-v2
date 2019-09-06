<?php

namespace App\Http\Requests;

use App\Models\Client;

class ClientRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $client = Client::find($this->route('client_id'));

        // Use ClientPolicy here to authorize before checking the fields
        return $current_user->can('store', Client::class)
            || $current_user->can('update', $client);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $client_id = $this->route('client_id');

        $rules = [
            'contact_id'     => 'nullable|exists:contacts,id|integer',

            // Address
            'address.street'        => 'required|string',
            'address.zip_code'      => 'required|integer',
            'address.city'          => 'required|string',
        ];

        switch($this->method())
        {
            case 'POST':
                $rules['name'] = 'required|string|unique:clients,name';
                break;
            case 'PUT':
            case 'PATCH':
                $rules['name'] = 'required|string|unique:clients,name,' . $client_id;
                break;
            default:break;
        }

        return $rules;
    }
}
