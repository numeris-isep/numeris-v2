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
        if ($current_user->can('store', Client::class)
            || $current_user->can('update', $client)
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
        $client_id = $this->ids;

        $rules = [
            // Address
            'street'        => 'required|string',
            'zip_code'      => 'required|integer',
            'city'          => 'required|string',
        ];

        switch($this->method())
        {
            case 'POST':
                $rules['name'] = 'required|string|unique:clients,name';
                $rules['reference'] = 'required|string|unique:clients,reference';
                break;

            case 'PUT':
            case 'PATCH':
                $rules['name'] = 'required|string|unique:clients,name,' . $client_id;
                $rules['reference'] = 'required|string|unique:clients,reference,' . $client_id;
                break;

            default:break;
        }

        return $rules;
    }
}
