<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvoicePolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to developers, administrators and staffs
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }

    public function download(User $current_user)
    {
        return false;
    }
}
