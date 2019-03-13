<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo('staff') && $ability != 'destroy') {
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

    public function show(User $current_user, Project $project)
    {
        return false;
    }

    public function update(User $current_user, Project $project)
    {
        return false;
    }

    public function updateStep(User $current_user, Project $project)
    {
        return false;
    }

    public function updatePayment(User $current_user, Project $project)
    {
        return false;
    }

    public function destroy(User $current_user, Project $project)
    {
        // TODO: only if there is no billing data or user = 'developer'
        return $current_user->role()->isEquivalentTo('developer');
    }
}
