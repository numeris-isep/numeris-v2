<?php

namespace App\Calculator;

use App\Models\Bill;
use App\Models\Project;
use App\Models\Role;
use App\Models\SocialContribution;
use App\Models\User;

class PayslipCalculator implements CalculatorInterface
{
    /**
     * Calculate payslips for projects of the given month
     *
     * @param null $params
     * @return array
     */
    public function calculate($params = null): array
    {
        $payslips = [];

        foreach ($this->sortBillsByUser(Project::findByMonth($params)) as $value) {
            $gross_amount       = $value['gross_amount'];
            $deductions         = $this->calculateDeductions($gross_amount);
            $net_amount         = $this->calculateNetAmount($gross_amount, $deductions['total_employee']);
            $subscription_fee   = $this->calculateSubscriptionFee($value['user'], $net_amount, $params);
            $final_amount       = $this->calculateFinalAmount($net_amount, $subscription_fee);

            if ($gross_amount > 0) {
                $payslips[] = [
                    'user_id'                       => $value['user']->id,
                    'month'                         => $params,
                    'gross_amount'                  => $gross_amount,
                    'net_amount'                    => $this->calculateNetAmount($gross_amount, $deductions['total_employee']),
                    'final_amount'                  => $final_amount,
                    'subscription_fee'              => $subscription_fee,
                    'deduction_amount'              => $deductions['total_employee'],
                    'employer_deduction_amount'     => $deductions['total_employer'],
                    'deductions'                    => json_encode($deductions['details']),
                    'operations'                    => json_encode($value['operations']),
                    'clients'                       => json_encode($value['clients']),
                ];
            }
        }

        return $payslips;
    }

    /**
     * Sort projects bills by user for further calculation
     *
     * @param $projects
     * @return array
     */
    private function sortBillsByUser($projects): array {
        $values = [];

        foreach ($projects as $project) {
            foreach ($project->missions as $mission) {
                foreach ($mission->bills as $bill) {
                    $values[$bill->application->user_id]['user'] = $bill->application->user;
                    $index = &$values[$bill->application->user_id];

                    // Create 'gross_amount' index and increment it
                    isset($index['gross_amount'])
                        ? $index['gross_amount'] += $this->calculateGrossAmount($bill)
                        : $index['gross_amount'] = $this->calculateGrossAmount($bill);

                    // Create 'operations' index and add missions references and start_at dates to it
                    $operation_info = ['reference' => $mission->reference, 'start_at' => $mission->start_at];
                    in_array($operation_info, $index['operations'] ?? [])
                        ?: $index['operations'][] = $operation_info;

                    // Create 'clients' index and add clients name to it
                    in_array($project->client->name, $index['clients'] ?? [])
                        ?: $index['clients'][] = $project->client->name;
                }
            }
        }

        return $values;
    }

    /**
     * Calculate the gross salary of a given bill
     *
     * The calculation will depends on the role of the user at the date of the
     * mission. This ensures that the gross salary does not change if the user's
     * role has been changed since the last calculation.
     *
     * @param Bill $bill
     * @return float
     */
    private function calculateGrossAmount(Bill $bill): float
    {
        $mission    = $bill->application->mission;
        $role       = $bill->application->user->roleAt($mission->created_at) ?: Role::findByName(Role::STUDENT);

        return $role->isSuperiorOrEquivalentTo(Role::STAFF)
            ? $bill->amount * $bill->rate->for_staff
            : $bill->amount * $bill->rate->for_student;
    }

    /**
     * Calculate social contributions deduction amounts
     *
     * This will calculate the deduction details of every social contribution as
     * well as the total deduction amounts for the employee and the employer.
     *
     * @param float $gross_amount
     * @return array
     */
    private function calculateDeductions(float $gross_amount): array
    {
        $deductions     = [];
        $total_employee = 0;
        $total_employer = 0;

        foreach (SocialContribution::all() as $social_contribution) {
            $deductions['details'][] = [
                'social_contribution'   => $social_contribution->name,
                'base'                  => $base_amount = $gross_amount * $social_contribution->base_rate,
                'employee_amount'       => $employee_deduction = $base_amount * ($social_contribution->student_rate / 100),
                'employer_amount'       => $employer_deduction = $base_amount * ($social_contribution->employer_rate / 100),
            ];

            $total_employee += $employee_deduction;
            $total_employer += $employer_deduction;
        }

        return array_merge($deductions, ['total_employee' => $total_employee, 'total_employer' => $total_employer]);
    }

    /**
     * Determine user's subscription fee
     *
     * The subscription fee will be applied if:
     *      - the user did not paid his subscription yet
     *          or
     *      - the user paid the subscription fee at the given date of calculation.
     *
     * @param User $user
     * @param float $net_amount
     * @param string $paid_at
     * @return float
     */
    private function calculateSubscriptionFee(User $user, float $net_amount, string $paid_at): float
    {
        if ($net_amount > 18) {
            if ($user->subscription_paid_at) {
                if ($user->subscription_paid_at === $paid_at) {
                    return 18;
                }
            } else {
                $user->update(['subscription_paid_at' => $paid_at]);
                return 18;
            }
        }

        return 0;
    }

    /**
     * Calculate the net amount of a given bill
     *
     * This deducts from user's gross amount the total amount of deductions.
     *
     * @param float $gross_amount
     * @param float $deduction
     * @return float
     */
    private function calculateNetAmount(float $gross_amount, float $deduction): float
    {
        return $gross_amount - $deduction;
    }

    /**
     * Calculate the final amount to be paid to the user
     *
     * This deducts from user's net salary the eventual subscription fee.
     *
     * @param float $net_amount
     * @param float $subscription_fee
     * @return float
     */
    private function calculateFinalAmount(float $net_amount, float $subscription_fee): float
    {
        return $net_amount - $subscription_fee;
    }
}
