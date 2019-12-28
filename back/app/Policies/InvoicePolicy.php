<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;

class InvoicePolicy
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

    public function download(User $current_user)
    {
        return true;
    }
}
