<?php

namespace App\Http\Controllers;

use App\Calculator\PayslipCalculator;
use App\Http\Requests\PayslipRequest;
use App\Http\Resources\PayslipResource;
use App\Models\Payslip;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PayslipRequest $request)
    {
        $this->authorize('index', Payslip::class);

        return response()->json(PayslipResource::collection(Payslip::findByYear($request['year'])));
    }

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

        $results = $calculator->calculate($request->get('month'));
        $payslips = collect();

        foreach ($results as $payslip) {
            $payslips->add(
                Payslip::updateOrCreate(['user_id' => $payslip['user_id'], 'month' => $payslip['month']], $payslip)->load('user')
            );
        }

        return response()->json(PayslipResource::collection($payslips));
    }
}
