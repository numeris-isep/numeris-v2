<?php

namespace App\Http\Requests;

class EmailRequest extends AbstractFormRequest
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
            'subject'       => 'required|string',
            'content'       => 'required|string',
            'attachments'   => 'file|mimes:jpeg,png,pdf,zip',
        ];
    }
}
