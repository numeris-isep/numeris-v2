<?php

namespace App\Http\Requests;

use App\Models\Bill;
use App\Models\Mission;

class BillRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $mission = Mission::findOrFail($this->route('mission_id'));

        // Use BillPolicy here to authorize before checking the fields
        return $current_user->can('update', [Bill::class, $mission]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'applications'                      => 'required|array|min:1',
            'applications.*.application_id'     => 'required|integer|exists:applications,id',
            'applications.*.bills'              => 'required|array|min:1',
            'applications.*.bills.*.rate_id'    => 'required|integer|exists:rates,id',
            'applications.*.bills.*.amount'     => 'required|numeric|min:0',
        ];
    }
}
