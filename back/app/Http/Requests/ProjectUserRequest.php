<?php

namespace App\Http\Requests;

use App\Models\Role;

class ProjectUserRequest extends AbstractFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->role()->isSuperiorOrEquivalentTo(Role::STAFF);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'required|exists:users,id|integer'
        ];
    }
}
