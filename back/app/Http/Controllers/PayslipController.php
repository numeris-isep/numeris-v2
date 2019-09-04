<?php

namespace App\Http\Controllers;

use App\Calculator\PayslipCalculator;
use App\Http\Requests\PayslipRequest;
use App\Models\Payslip;

class PayslipController extends Controller
{
    /**
     * Update the specified resources in storage.
     *
     * @param PayslipRequest $request
     * @param PayslipCalculator $calculator
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(PayslipRequest $request, PayslipCalculator $calculator)
    {
        $this->authorize('update', Payslip::class);

        $payslips = $calculator->calculate($request->get('month'));

        foreach ($payslips as $payslip) {
            Payslip::updateOrCreate(['user_id' => $payslip['user_id'], 'month' => $payslip['month']], $payslip);
        }

        return response()->json($payslips);
    }
}
