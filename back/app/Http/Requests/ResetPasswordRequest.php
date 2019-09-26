<?php

namespace App\Http\Requests;

class ResetPasswordRequest extends AbstractFormRequest
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
            'email'     => 'required|email|exists:',
            'password'  => 'required|confirmed|min:8',
            'token'     => 'required',
        ];
    }
}
