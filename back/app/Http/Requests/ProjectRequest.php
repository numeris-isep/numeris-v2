<?php

namespace App\Http\Requests;

class ProjectRequest extends AbstractFormRequest
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
        $project_id = $this->ids;

        $rules = [
            'client_id'     => 'required|integer',
//            'convention_id' => 'required|integer', TODO
            'start_at'      => 'required|date',
            'is_private'    => 'boolean',
        ];

        switch($this->method())
        {
            case 'POST':
                $rules['name'] = 'required|string|unique:projects,name';
                break;

            case 'PUT':
                $rules['name'] = 'required|string|unique:projects,name,' . $project_id;
                break;

            case 'PATCH':
                // TODO
                break;

            default:break;
        }

        return $rules;
    }
}
