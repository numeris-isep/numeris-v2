<?php

namespace App\Http\Controllers;

use App\Calculator\PayslipCalculator;
use App\Http\Requests\PayslipRequest;
use App\Http\Resources\PayslipResource;
use App\Models\Payslip;
use Barryvdh\DomPDF\Facade as PDF;

class PayslipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param PayslipRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(PayslipRequest $request)
    {
        $this->authorize('index', Payslip::class);

        return response()->json(PayslipResource::collection(Payslip::findByYear($request['year'])));
    }

    /**
     * Download a given payslip PDF.
     *
     * @param $payslip_id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function downloadPayslip($payslip_id)
    {
        /** @var Payslip $payslip */
        $payslip = Payslip::findOrFail($payslip_id);
        $this->authorize('show', $payslip);

        return PDF::loadView('files.payslip', ['payslip' => $payslip])
            ->download($payslip->generatePayslipName());
    }

    /**
     * Download a given contract PDF.
     *
     * @param $payslip_id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function downloadContract($payslip_id)
    {
        /** @var Payslip $payslip */
        $payslip = Payslip::findOrFail($payslip_id);
        $this->authorize('show', $payslip);

        return PDF::loadView('files.contract', ['payslip' => $payslip])
            ->download($payslip->generateContractName());
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
