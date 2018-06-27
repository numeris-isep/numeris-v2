<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers
        if ($current_user->role()->isEquivalentTo('developer')) {
            return true;
        }

        if ($current_user->role()->isSuperiorTo('student')) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }

    public function store(User $current_user)
    {
        return false;
    }

    public function show(User $current_user, Address $address)
    {
        // $user1 whose $role < 'developer' can't show $address
        // unless   $user1 == $address->user
        // or       $user1->role > 'student'    <-- handled in before() method
        return $current_user->is($address->user);
    }

    public function update(User $current_user, Address $address)
    {
        // $user1 whose $role < 'developer' can't update $address
        // unless   $user1 == $address->user
        // or       $user1->role > 'student'    <-- handled in before() method
        return $current_user->is($address->user);
    }

    public function destroy(User $current_user, User $user)
    {
        // Only for developers
        return true;
    }
}
