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
        $current_user = auth()->user();
        $user = User::find($this->route('user_id'));

        // Use UserPolicy here to authorize before checking the fields
        return $current_user->can('store', User::class)
            || $current_user->can('update', $user)
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
            'student_number'            => 'nullable|numeric',
            'promotion'                 => 'nullable|numeric',
        ];

        $patch_rules = [
            'phone'                     => 'required|string|min:10',
            'nationality'               => 'required|string',
            'birth_date'                => 'required|date',
            'birth_city'                => 'required|string',
            'social_insurance_number'   => 'required|string',
            'iban'                      => 'required|string|min:13',
            'bic'                       => 'required|string',

            // Address
            'street'                    => 'required|string',
            'zip_code'                  => 'required|integer',
            'city'                      => 'required|string',
        ];

        switch($this->method())
        {
            case 'POST':
                $rules['email'] = 'required|email|unique:users,email';
                $rules['username'] = 'required|string|alpha|unique:users,username';
                break;
            case 'PUT':
                $rules['email'] = 'required|email|unique:users,email,' . $user_id;
                $rules['username'] = 'required|string|alpha|unique:users,username,' . $user_id;
                break;
            case 'PATCH':
                return $patch_rules;
                break;
            default:break;
        }

        $rules = array_merge($rules, $patch_rules);

        return $rules;
    }
}
