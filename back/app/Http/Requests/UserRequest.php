<?php

namespace App\Http\Requests;

use App\Models\User;
use Carbon\Carbon;

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
        $user_id = $this->route('user_id');

        $rules = [
            'password'          => 'confirmed|min:8',
            'first_name'        => 'required|string',
            'last_name'         => 'required|string',
            'email'             => 'required|email|regex:^[a-zA-Z0-9_.+-]+@(?:(?:[a-zA-Z0-9-]+\.)?[a-zA-Z]+\.)?(isep)\.fr$^',
            'promotion'         => 'required|integer|min:' . now()->year,
            'birth_date'        => 'required|date',

            // Address
            'address.street'    => 'required|string',
            'address.zip_code'  => 'required|integer',
            'address.city'      => 'required|string',
        ];

        $put_rules = [
            'phone'                     => 'required|string|min:10',
            'nationality'               => 'required|string',
            'birth_city'                => 'required|string',
            'social_insurance_number'   => 'required|string|size:15',
            'iban'                      => 'required|string|min:15',
            'bic'                       => 'required|string|size:8',
        ];

        switch($this->method())
        {
            case 'POST':
                $rules['email'] = $rules['email'] . '|unique:users,email';
                $rules['password'] = $rules['password'] . '|required';
                return $rules;
            case 'PUT':
                $rules['email'] = $rules['email'] . '|unique:users,email,' . $user_id;
                $rules['password'] = $rules['password'] . '|nullable';
                return array_merge($rules, $put_rules);
            default:break;
        }
    }
}
