<?php

namespace App\Calculator;

use App\Models\Bill;
use App\Models\Project;
use App\Models\Role;
use App\Models\SocialContribution;
use App\Models\User;
use Carbon\Carbon;
use function PHPSTORM_META\elementType;

class PayslipCalculator implements CalculatorInterface
{
    /**
     * Calculate payslips for projects of the given month
     *
     * @param $month
     * @param array $users
     * @return array
     */
    public function calculate($month, $users = []): array
    {
        $payslips = [];

        foreach ($this->sortBillsByUser(Project::findByMonth($month), $users) as $value) {
            $hour_amount        = $value['hour_amount'];
            $gross_amount       = $value['gross_amount'];
            $deductions         = $this->calculateDeductions($gross_amount);
            $net_amount         = $this->calculateNetAmount($gross_amount, $deductions['total_employee']);
            $subscription_fee   = $this->calculateSubscriptionFee($value['user'], $net_amount, $month);
            $final_amount       = $this->calculateFinalAmount($net_amount, $subscription_fee);

            if ($gross_amount > 0) {
                $payslips[] = [
                    'user_id'                       => $value['user']->id,
                    'month'                         => $month,
                    'hour_amount'                   => $hour_amount,
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
     * @param array $users
     * @return array
     */
    private function sortBillsByUser($projects, $users = []): array {
        $values = [];

        foreach ($projects as $project) {
            foreach ($project->missions as $mission) {
                foreach ($mission->bills as $bill) {
                    if (count($users) == 0 || (count($users) > 0 && in_array($bill->application->user->id, $users))) {
                        $values[$bill->application->user_id]['user'] = $bill->application->user;
                        $index = &$values[$bill->application->user_id];

                        // Create 'gross_amount' index and increment it
                        isset($index['gross_amount'])
                            ? $index['gross_amount'] += $this->calculateGrossAmount($bill)
                            : $index['gross_amount'] = $this->calculateGrossAmount($bill);

                        // Create 'hour_amount' index and increment it
                        isset($index['hour_amount'])
                            ? $index['hour_amount'] += $bill->amount
                            : $index['hour_amount'] = $bill->amount;

                        // Create 'operations' index and add missions references and start_at dates to it
                        $mission_info = ['id' => $mission->id, 'reference' => $mission->reference, 'startAt' => $mission->start_at];
                        in_array($mission_info, $index['operations'] ?? [])
                            ?: $index['operations'][] = $mission_info;

                        // Create 'clients' index and add clients name to it
                        $client_info = ['id' => $project->client->id, 'name' => $project->client->name];
                        in_array($client_info, $index['clients'] ?? [])
                            ?: $index['clients'][] = $client_info;
                    }
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
            $employee_deduction = 0;
            $employer_deduction = 0;

            $deductions['details'][] = [
                'socialContribution'    => $social_contribution->name,
                'base'                  => $base_amount = $gross_amount * $social_contribution->base_rate,
                'employeeRate'          => $social_contribution->student_rate,
                'employerRate'          => $social_contribution->employer_rate,
                'employeeAmount'        => $employee_deduction = $base_amount * ($social_contribution->student_rate / 100),
                'employerAmount'        => $employer_deduction = $base_amount * ($social_contribution->employer_rate / 100),
            ];

            $total_employee += $employee_deduction;
            $total_employer += $employer_deduction;
        }

        return array_merge($deductions, ['total_employee' => $total_employee, 'total_employer' => $total_employer]);
    }

    /**
     * Determine user's subscription fee for the given month
     *
     * The fee is digressive, which means that the amount will change according
     * to the number of paid months :
     *      - first month   --> 10€
     *      - second month  --> 5€
     *      - third month   --> 5€
     *      - after         --> 0€ (subscription fully paid)
     *
     * @param User $user
     * @param float $net_amount
     * @param string $month
     * @return float
     */
    private function calculateSubscriptionFee(User $user, float $net_amount, string $month): float
    {
        $dates_count = count($user->subscription_dates ?? []);

        switch (true) {
            case $dates_count == 0:
                // Case where it is the first time we calculate payslips for the
                // given user. This means he does not have any subscription_dates.
                // We would update $user->subscription_date and return a fee amount
                // only if the $net_amount > User::SUBSCRIPTION_0, this to prevent
                // a negative $final_amount
                if ($net_amount >= User::SUBSCRIPTION_0) {
                    $user->update(['subscription_dates' => [$month]]);
                    return User::SUBSCRIPTION_0;
                }
                break;

            case $dates_count <= 3:
                if (is_int($index = array_search($month, $user->subscription_dates))) {
                    // Case where we are recalculating payslips so we need to find the
                    // index of $month in $user->subscription_dates to determine the
                    // correct subscription amount

                    if ($net_amount > $amount = User::subscriptionMatrix()[$index]) {
                        // No need to update $user->subscription_dates because this is
                        // a recalculation. We only return the same fee $amount than
                        // the previous calculation(s)
                        return $amount;
                    }
                } else {
                    $calculation_month  = Carbon::parse($month);
                    $last_month         = Carbon::parse($user->subscription_dates[$dates_count - 1]);

                    // We consider that another subscription fee will be applied only
                    // if $month is after the last $user->subscription_date
                    if ($calculation_month->isAfter($last_month) && $dates_count < 3) {
                        // Here we are also preventing a negative $final_amount (see above)
                        if ($net_amount > $amount = User::subscriptionMatrix()[$dates_count]) {
                            $user->update(['subscription_dates' => array_merge(
                                $user->subscription_dates,
                                [$month]
                            )]);

                            return $amount;
                        }
                    }
                }
                break;

            default: break;
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
