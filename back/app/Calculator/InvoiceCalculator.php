<?php

namespace App\Calculator;

use App\Models\Project;
use App\Models\Rate;

class InvoiceCalculator implements CalculatorInterface
{
    /**
     * Calculate client invoice for the given project
     *
     * @param array $params
     * @return array
     */
    public function calculate($params): array
    {
        $details        = $this->calculateDetails($params['project']);
        $hour_amount    = $details['hour_amount'];
        $gross_amount   = $details['gross_amount'];
        $vat_amount     = $this->calculateVAT($gross_amount);
        $final_amount   = $this->calculateFinalAmount($gross_amount, $vat_amount);

        return [
            'project_id'    => $params['project']->id,
            'hour_amount'   => $hour_amount,
            'gross_amount'  => $gross_amount,
            'vat_amount'    => $vat_amount,
            'final_amount'  => $final_amount,
            'details'       => json_encode($details['details']),
            'time_limit'    => $params['time_limit'],
        ];
    }

    /**
     * Calculate the gross amount and the number of hours
     *
     * @param Project $project
     * @return array
     */
    public function calculateDetails(Project $project): array
    {
        $details = [
            'gross_amount'  => 0,
            'hour_amount'  => 0,
            'details'       => []
        ];

        foreach ($project->missions as $mission) {
            $detail = [
                'reference' => $mission->reference,
                'title'     => $mission->title,
                'startAt'   => $mission->start_at,
                'bills'     => [],
            ];

            foreach ($mission->bills->groupBy('rate_id') as $rate_id => $bills) {
                $rate = Rate::findOrFail($rate_id);
                $hours = $bills->sum('amount');
                $details['gross_amount'] += $rate->for_client * $hours;
                $details['hour_amount'] += $hours;

                $detail['bills'][] = [
                    'rate' => $rate->name,
                    'amount' => $rate->for_client,
                    'hours' => $hours,
                    'total' => $rate->for_client * $hours,
                ];
            }

            $details['details'][] = $detail;
        }

        return $details;
    }

    /**
     * Calculate the VAT amount
     *
     * The VAT amount is equals to 20% of the gross amount.
     *
     * @param float $gross_amount
     * @return float
     */
    private function calculateVAT(float $gross_amount): float
    {
        return $gross_amount * 0.2;
    }

    /**
     * Calculate the final amount to be paid by the client
     *
     * This adds to the gross amount the VAT amount.
     *
     * @param float $gross_amount
     * @param float $vat_amount
     * @return float
     */
    private function calculateFinalAmount(float $gross_amount, float $vat_amount): float
    {
        return $gross_amount + $vat_amount;
    }
}
