<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Mission;
use Illuminate\Auth\Access\HandlesAuthorization;

class MissionPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo('staff')) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return true;
    }

    public function store(User $current_user)
    {
        return false;
    }

    public function storeApplication(User $current_user)
    {
        return false;
    }

    public function show(User $current_user, Mission $mission)
    {
        return false;
    }

    public function update(User $current_user, Mission $mission)
    {
        return false;
    }

    public function updateLock(User $current_user, Mission $mission)
    {
        return false;
    }

    public function destroy(User $current_user, Mission $mission)
    {
        return false;
    }
}
