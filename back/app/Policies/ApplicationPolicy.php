<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Application;
use App\Models\Project;
use App\Models\User;

class ApplicationPolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers
        if ($current_user->role()->isEquivalentTo(Role::DEVELOPER)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function indexStatus(User $current_user)
    {
        return $current_user->role()->isSuperiorTo(Role::STUDENT);
    }

    public function update(User $current_user, Application $application)
    {
        // Impossible to update an application if the step of the project is
        // different than 'hiring'
        return $current_user->role()->isInferiorTo(Role::STAFF)
            ? $this->deny(trans('errors.403'))
            : $application->mission->project->step == Project::HIRING
                ?: $this->deny(trans('errors.wrong_project_step', ['allowed_step' => 'Ouvert']))
        ;
    }

    public function destroy(User $current_user, Application $application)
    {
        // $user1 whose $role < 'staff' can't delete the $application of $user2
        // unless   $user1 == $application->user
        return $current_user->is($application->user);
    }
}
