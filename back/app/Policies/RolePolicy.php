<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class RolePolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, staffs and administrators
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }
}
