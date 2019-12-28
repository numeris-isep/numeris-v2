<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Preference;
use App\Models\User;

class PreferencePolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers
        if ($current_user->role()->isEquivalentTo(Role::DEVELOPER)) {
            return true;
        }
    }

    public function update(User $current_user, Preference $preference)
    {
        // $user1 whose $role < 'developer' can't update the preferences of $user2
        // unless   $user1 == $user2
        // or       $user1->role > $user2->role
        return $current_user->is($preference->user)
            ?: (
            $current_user->role()->isSuperiorTo($preference->user->role()->name)
                ?: $this->deny(trans('errors.roles.' . $current_user->role()->name))
            );
    }
}
