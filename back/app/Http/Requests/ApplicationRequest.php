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

        // Use ApplicationPolicy, MissionPolicy and UserPolicy here to authorize
        // before checking the fields
        return $current_user->can('store-application', Mission::class)
            || $current_user->can('store-application', User::class)
            || $current_user->can('update', $application);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'mission_id'    => 'integer|exists:missions,id|unique:applications,mission_id,NULL,NULL,user_id,' . $this->user_id,
            'user_id'       => 'integer|exists:users,id|unique:applications,user_id,NULL,NULL,mission_id,' . $this->mission_id,
        ];

        switch($this->method())
        {
            case 'PUT':
                return [
                    'type'      => 'required_without:status|in:' . implode(',', Application::types()),
                    'status'    => 'required_without:type|in:' . implode(',', Application::statutes()),
                ];
                break;

            default:break;
        }

        return $rules;
    }
}
