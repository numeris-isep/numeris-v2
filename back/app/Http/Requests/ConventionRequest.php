<?php

namespace App\Http\Requests;

use App\Models\Convention;

class ConventionRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $convention = Convention::find($this->route('convention_id'));

        // Use ClientPolicy here to authorize before checking the fields
        return $current_user->can('store', Convention::class)
            || $current_user->can('update', $convention);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $convention_id = $this->ids;

        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|string|unique:conventions,name',
                ];

            case 'PUT':
            case 'PATCH':
                return [
                    'name' => 'required|string|unique:conventions,name,' . $convention_id,
                ];

            default:break;
        }
    }
}
