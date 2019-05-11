<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectUserPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Forbid everything to students
        if ($current_user->role()->isInferiorTo('staff')) {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return true;
    }

    public function store(User $current_user, Project $project, User $user)
    {
        return ! $project->users->contains($user);
    }

    public function destroy(User $current_user, Project $project, User $user)
    {
        return $project->users->contains($user);
    }
}
