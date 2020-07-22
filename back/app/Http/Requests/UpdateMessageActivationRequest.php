<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Message;

class UpdateMessageActivationRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $message = Message::find($this->route('message_id'));

        // Use MessagePolicy here to authorize before checking the fields
        return $current_user->can('updateActivated', $message);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_active'    => 'required|boolean',
        ];
    }
}
