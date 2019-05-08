<?php

namespace App\Policies;

use App\Models\Application;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo('staff') && $ability != 'destroy') {
            return true;
        }
    }

    public function indexStatus(User $current_user)
    {
        return false;
    }

    public function update(User $current_user, Application $application)
    {
        return false;
    }

    public function destroy(User $current_user, Application $application)
    {
        // $user1 whose $role < 'staff' can't delete the $application of $user2
        // unless   $user1 == $application->user
        return $current_user->is($application->user);
    }
}
