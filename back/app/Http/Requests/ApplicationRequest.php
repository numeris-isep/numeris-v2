<?php

namespace App\Http\Requests;

use App\Models\Application;
use App\Models\Mission;
use App\Models\User;

class ApplicationRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $current_user = auth()->user();
        $application = Application::find($this->route('application_id'));
        if ($application) {
            // Use ApplicationPolicy here to authorize before checking the fields
            return $current_user->can('update', $application);
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->route()->getName() === 'applications.index') {
            return ['year' => 'required|string|date_format:Y'];
        }

        $rules = [
            'mission_id'    => 'integer|exists:missions,id|unique:applications,mission_id,NULL,id,user_id,' . $this->user_id,
            'user_id'       => 'integer|exists:users,id|unique:applications,user_id,NULL,id,mission_id,' . $this->mission_id,
        ];

        switch($this->method())
        {
            case 'PUT':
            case 'PATCH':
                return [
                    'type'      => 'required_without:status|in:' . implode(',', Application::types()),
                    'status'    => 'required_without:type|in:' . implode(',', Application::statuses()),
                ];
                break;
            default:break;
        }

        return $rules;
    }
}
