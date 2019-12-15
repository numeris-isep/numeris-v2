<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use App\Models\Mission;

class MissionPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF) && $ability != 'destroy') {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }

    public function indexAvailable(User $current_user)
    {
        return true;
    }

    public function indexMissionApplication(User $current_user)
    {
        return false;
    }

    public function indexNotApplied(User $current_user, Mission $mission)
    {
        return false;
    }

    public function store(User $current_user)
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
        return $mission->bills->count() > 0
            ? $current_user->role()->isEquivalentTo(Role::DEVELOPER)
            : $current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF);
    }

    public function sendEmail(User $current_user, Mission $mission)
    {
        return false;
    }

    public function notifyAvailability(User $current_user)
    {
        return false;
    }
}
