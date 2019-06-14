<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Rate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RatePolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)) {
            return true;
        }

        // Forbid everything to students
        return false;
    }

    public function store(User $current_user)
    {
        return false;
    }

    public function update(User $current_user, Rate $rate)
    {
        return false;
    }

    public function destroy(User $current_user, Rate $rate)
    {
        return false;
    }
}
