<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Convention;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ConventionPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs (expect destroy)
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF) && $ability != 'destroy') {
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

    public function show(User $current_user, Convention $convention)
    {
        return false;
    }

    public function update(User $current_user, Convention $convention)
    {
        return false;
    }

    public function destroy(User $current_user, Convention $convention)
    {
        return $current_user->role()->isSuperiorOrEquivalentTo(Role::ADMINISTRATOR)
            && $convention->projects()->count() == 0;
    }
}
