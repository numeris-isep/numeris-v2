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
            'first_name'    => 'required|string',
            'last_name'     => 'required|string',
            'email'         => 'required|email',
            'subject'       => 'required|string',
            'content'       => 'required|string',
        ];
    }
}
