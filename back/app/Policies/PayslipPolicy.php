<?php

namespace App\Policies;

use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayslipPolicy
{
    use HandlesAuthorization;

    public function before(User $current_user, $ability)
    {
        // Grant everything to staff, administrator and developer
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF)) {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }

    public function show(User $current_user, Payslip $payslip)
    {
        return $current_user->is($payslip->user);
    }

    public function update(User $current_user)
    {
        return false;
    }
}
