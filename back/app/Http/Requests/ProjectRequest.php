<?php

namespace App\Http\Requests;

use App\Models\Project;

class ProjectRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $project = Project::find($this->route('project_id'));

        // Use ProjectPolicy here to authorize before checking the fields
        if ($current_user->can('store', Project::class)
            || $current_user->can('update', $project)
        ) {
            return true;
        }

        return false;
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
            'client_id'     => 'required|exists:clients,id|integer',
            'convention_id' => 'required|exists:conventions,id|integer',
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
                return [
                    'step'              => 'required_without:money_received_at|string|in:' . implode(',', Project::steps()),
                    'money_received_at' => 'required_without:step|date'
                ];

            default:break;
        }

        return $rules;
    }
}
