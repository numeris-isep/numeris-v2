<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Convention;
use App\Models\User;

class ConventionPolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Forbid everything to students
        if ($current_user->role()->isInferiorTo(Role::STAFF)) {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return true;
    }

    public function store(User $current_user)
    {
        return true;
    }

    public function show(User $current_user, Convention $convention)
    {
        return true;
    }

    public function update(User $current_user, Convention $convention)
    {
        return $convention->projects()->count() == 0
            ?: $this->deny(trans('errors.convention_has_project'));
    }

    public function destroy(User $current_user, Convention $convention)
    {
        return $current_user->role()->isInferiorTo(Role::ADMINISTRATOR)
            ? $this->deny(trans('errors.roles.' . Role::STAFF))
            : (
                $convention->projects()->count() == 0
                    ?: $this->deny(trans('errors.convention_has_project'))
            );
    }
}
