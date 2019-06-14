<?php

namespace App\Http\Requests;

use App\Models\Role;

class UserRoleRequest extends AbstractFormRequest
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
            'role_id' => 'required|exists:roles,id|integer'
        ];
    }
}
