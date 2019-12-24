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
        $current_user = auth()->user();

        switch ($this->route()->getName()) {
            case 'payslips.index':
                return $current_user->can('index', Payslip::class);
            case 'payslips.podium.index':
                return true;
            case 'payslips.update':
            case 'payslips.update.partial':
                return $current_user->can('update', Payslip::class);
            default:
                return false;
        }
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
            case 'PATCH':
                return [
                    'payslips'          => 'required|array',
                    'payslips.*'        => 'required|array',
                    'payslips.*.id'     => 'required|exists:payslips,id',
                    'payslips.*.signed' => 'required_without:payslips.*.paid|boolean',
                    'payslips.*.paid'   => 'required_without:payslips.*.signed|boolean',
                ];
            default: break;
        }
    }
}
