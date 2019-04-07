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
        // Grant everything to developers and administrators
        if ($current_user->role()->isInferiorTo('staff')) {
            return false;
        }
    }

    public function index(User $current_user)
    {
        return false;
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
