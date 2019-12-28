<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Mission;
use App\Models\Project;
use App\Models\User;

class BillPolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Forbid everything to students
        if ($current_user->role()->isInferiorTo(Role::STAFF)) {
            return false;
        }
    }

    public function update(User $current_user, Mission $mission)
    {
        return $mission->project->step == Project::VALIDATED;
    }
}
