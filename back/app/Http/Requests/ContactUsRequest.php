<?php

namespace App\Http\Requests;

class ContactUsRequest extends AbstractFormRequest
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
            'recaptcha_token'   => 'required|recaptcha',

            'data.first_name'   => 'required|string',
            'data.last_name'    => 'required|string',
            'data.email'        => 'required|email',
            'data.subject'      => 'required|string',
            'data.content'      => 'required|string',
        ];
    }
}
