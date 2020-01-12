<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Project;
use App\Models\User;

class ProjectUserPolicy extends AbstractPolicy
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

    public function store(User $current_user, Project $project, User $user)
    {
        return $user->deleted_at
            ? $this->deny(trans('errors.profile_deleted'))
            : (
                ! $project->users->contains($user)
                    ?: $this->deny(trans('errors.project_contains_user'))
            );
    }

    public function destroy(User $current_user, Project $project, User $user)
    {
        return $user->deleted_at
            ? $this->deny(trans('errors.profile_deleted'))
            : (
                $project->users->contains($user)
                    ?: $this->deny(trans('errors.project_doesnot_contain_user'))
            );
    }
}
