<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Message;

class MessageRequest extends AbstractFormRequest
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

        // Use ContactPolicy here to authorize before checking the fields
        return $current_user->can('store', Message::class)
            || $current_user->can('update', $message);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'    => 'required|string',
            'content'  => 'required|string',
            'link'     => 'string|url'
        ];
    }
}
