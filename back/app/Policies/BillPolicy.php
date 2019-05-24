<?php

namespace App\Policies;

use App\Models\Mission;
use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Forbid everything to students
        if ($current_user->role()->isInferiorTo('staff')) {
            return false;
        }
    }

    public function update(User $current_user, Mission $mission)
    {
        return $mission->project->step == Project::VALIDATED;
    }
}
