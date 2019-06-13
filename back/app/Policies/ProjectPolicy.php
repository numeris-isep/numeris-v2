<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    private $message = 'Accès interdit.';

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

    public function indexStep(User $current_user)
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
        return $project->bills()->count() > 0
            ? $current_user->role()->isEquivalentTo('developer')
            : $current_user->role()->isSuperiorOrEquivalentTo('staff');
    }
}
