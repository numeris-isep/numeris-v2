<?php

namespace App\Http\Requests;

use App\Models\Contact;

class ContactRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $contact = Contact::find($this->route('contact_id'));

        // Use ContactPolicy here to authorize before checking the fields
        return $current_user->can('store', Contact::class)
            || $current_user->can('update', $contact);
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
            'email'         => 'nullable|email',
            'phone'         => 'nullable|string|min:10',
        ];
    }
}
