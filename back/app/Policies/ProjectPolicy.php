<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Project;
use App\Models\User;

class ProjectPolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if (
            $current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)
            && $ability !== 'update-invoice'
            && $ability !== 'destroy'
        ) {
            return true;
        }

        if ($current_user->role()->isInferiorTo(Role::STAFF)) {
            return false;
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

    public function updateInvoice(User $current_user, Project $project)
    {
        return $project->bills()->isNotEmpty()
            ?: $this->deny(trans('errors.no_bill_on_project'));
    }

    public function destroy(User $current_user, Project $project)
    {
        return $project->bills()->count() == 0
            ?: (
                $current_user->role()->isEquivalentTo(Role::DEVELOPER)
                    ?: $this->deny(trans('errors.roles.' . Role::ADMINISTRATOR))
            );
    }
}
