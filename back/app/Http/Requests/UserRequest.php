<?php

namespace App\Http\Requests;

use App\Models\User;

class UserRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->route()->getName() === 'subscribe') {
            return true;
        }

        $current_user = auth()->user();
        $user = User::find($this->route('user_id'));

        // Use UserPolicy here to authorize before checking the fields
        return $current_user->can('update', $user)
            || $current_user->can('update-profile', $user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $user_id = $this->ids;

        $rules = [
            'password'                  => 'required|confirmed',
            'first_name'                => 'required|string',
            'last_name'                 => 'required|string',
            'promotion'                 => 'nullable|numeric',
            'birth_date'                => 'required|date',

            // Address
            'street'                    => 'required|string',
            'zip_code'                  => 'required|integer',
            'city'                      => 'required|string',
        ];

        $put_rules = [
            'phone'                     => 'required|string|min:10',
            'nationality'               => 'required|string',
            'birth_city'                => 'required|string',
            'social_insurance_number'   => 'required|string',
            'iban'                      => 'required|string|min:13',
            'bic'                       => 'required|string',
        ];

        switch($this->method())
        {
            case 'POST':
                $rules['email'] = 'required|email|regex:^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(isep)\.fr$^|unique:users,email';
                return $rules;
            case 'PUT':
                $rules['email'] = 'required|email|regex:^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(isep)\.fr$^|unique:users,email,' . $user_id;
                return array_merge($rules, $put_rules);
            default:break;
        }
    }
}
