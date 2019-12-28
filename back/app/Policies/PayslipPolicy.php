<?php

namespace App\Policies;

use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PayslipPolicy extends AbstractPolicy
{
    public function before(User $current_user, $ability)
    {
        // Grant everything to staff, administrator and developer
        if ($current_user->role()->isSuperiorOrEquivalentTo(Role::STAFF) && $ability != 'download-zip') {
            return true;
        }
    }

    public function index(User $current_user)
    {
        return false;
    }

    public function downloadPayslip(User $current_user, Payslip $payslip)
    {
        return $current_user->is($payslip->user);
    }

    public function downloadContract(User $current_user, Payslip $payslip)
    {
        return $current_user->is($payslip->user);
    }

    public function downloadZip(User $current_user, Collection $payslips)
    {
        return $current_user->role()->isInferiorTo(Role::STAFF)
            ? false
            : (
                $payslips->isNotEmpty()
                    ?: $this->deny(trans('errors.no_payslip_for_month'))
            );
    }

    public function update(User $current_user)
    {
        return false;
    }
}
