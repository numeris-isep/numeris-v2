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
        // Forbid everything to students
        if ($current_user->role()->isInferiorTo(Role::STAFF)) {
            return false;
        }
    }

    public function show(User $current_user, Convention $convention)
    {
        return true;
    }

    public function update(User $current_user, Convention $convention)
    {
        return $convention->projects()->count() == 0
            ?: $this->deny(trans('errors.conventions.projects'));
    }

    public function destroy(User $current_user, Convention $convention)
    {
        return $current_user->role()->isInferiorTo(Role::ADMINISTRATOR)
            ? $this->deny(trans('errors.roles.' . Role::STAFF))
            : (
                $convention->projects()->count() == 0
                    ?: $this->deny(trans('errors.conventions.projects'))
            );
    }
}
