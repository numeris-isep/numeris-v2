<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class UserRolePolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isInferiorTo(Role::STAFF) && $ability != 'index') {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function store(User $current_user, User $user, Role $role)
    {
        // Only $current_user->role >= $user->role can change $user->role
        // AND
        // $current_user->role >= $role
        // AND
        // ! $user->deleted_at
        // AND
        // $user->role != $role
        return $user->deleted_at
            ? $this->deny(trans('errors.profile_deleted'))
            : (
                $current_user->role()->isInferiorTo($user->role()->name)
                    ? $this->deny(trans('errors.roles.' . $current_user->role()->name))
                    : (
                        $current_user->role()->isInferiorTo($role->name)
                            ? $this->deny(trans('errors.roles.superior'))
                            : (
                                $user->role()->isNot($role)
                                    ?: $this->deny(trans('errors.roles.same', ['role' => $role->name_fr]))
                        )
                    )
            );
    }
}
