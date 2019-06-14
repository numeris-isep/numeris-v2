<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AddressPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers
        if ($current_user->role()->isEquivalentTo(Role::DEVELOPER)) {
            return true;
        }

        if ($current_user->role()->isSuperiorTo(Role::STUDENT)
            && ($ability == 'index' || $ability == 'show')
        ) {
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
        return false;
    }

    public function update(User $current_user, Address $address)
    {
        return false;
    }

    public function destroy(User $current_user, Address $address)
    {
        return false;
    }
}
