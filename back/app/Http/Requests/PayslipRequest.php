<?php

namespace App\Http\Requests;

use App\Models\Payslip;

class PayslipRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->can('update', Payslip::class);
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
            case 'PUT':
                return [
                    'month' => 'required|string|date',
                ];
            default: break;
        }
    }
}
