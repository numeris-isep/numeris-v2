<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers
        if ($current_user->role()->isEquivalentTo(Role::DEVELOPER) && $ability != 'update-terms-of-use') {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function indexPromotion(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function indexUserApplication(User $current_user, User $user)
    {
        return $current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)
            || $current_user->is($user);
    }

    public function store(User $current_user)
    {
        return false;
    }

    public function show(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't show the profile of $user2
        // unless   $user1 == $user2
        // or       $user1->role > 'student'
        return $current_user->is($user)
            || $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function update(User $current_user, User $user)
    {
        return false;
    }

    public function updateProfile(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't update the profile of $user2
        // unless   $user1 == $user2
        // or       $user1->role > $user2->role
        return $current_user->is($user)
            || $current_user->role()->isSuperiorTo($user->role()->name);
    }

    public function updateTermsOfUse(User $current_user, User $user)
    {
        // $user1 whose $role < 'developer' can't update the profile of $user2
        // unless   $user1 == $user2
        // or       $user1->role > $user2->role
        // AND      $user->tou_accepted != true
        return ($current_user->is($user)
            || $current_user->role()->isSuperiorTo($user->role()->name))
            && ! $user->tou_accepted;
    }

    public function destroy(User $current_user, User $user)
    {
        // $user1 whose $role < 'administrator' can't delete the profile of $user2
        // unless   $user1 == $user2
        return $current_user->is($user)
            || $current_user->role()->isSuperiorOrEquivalentTo(Role::ADMINISTRATOR);
    }
}
