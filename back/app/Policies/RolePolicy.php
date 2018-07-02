<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers and administrators
        if ($current_user->role()->isSuperiorOrEquivalentTo('administrator')) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }
}
