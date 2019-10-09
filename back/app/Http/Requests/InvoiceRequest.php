<?php

namespace App\Http\Requests;

use App\Models\Invoice;

class InvoiceRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();

        return $current_user->can('index', Invoice::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method())
        {
            case 'POST':
                return [
                    'year' => 'required|string|date_format:Y',
                ];
            default: break;
        }
    }
}
