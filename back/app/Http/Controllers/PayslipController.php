<?php

namespace App\Http\Controllers;

use App\Calculator\PayslipCalculator;
use App\Http\Requests\PayslipRequest;
use App\Http\Resources\PayslipResource;
use App\Models\Payslip;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        $payslips = Payslip::findByYear($request['year'])->load(['user']);

        return response()->json(PayslipResource::collection($payslips));
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
        $this->authorize('download-payslip', $payslip);

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
        $this->authorize('download-contract', $payslip);

        return PDF::loadView('files.contract', ['payslip' => $payslip])
            ->download($payslip->generateContractName());
    }

    /**
     * Download a ZIP archive containing contracts an payslips of a given month
     *
     * Note: this takes a bit of time
     *          ¯\_(ツ)_/¯
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function downloadZip(Request $request)
    {
        set_time_limit(0); // Necessary because this task can take a while

        $payslips = Payslip::findByMonth($request['month']);
        $this->authorize('download-zip', [Payslip::class, $payslips]);

        $zip = new \ZipArchive();
        $zip_name = sprintf('%s_documents.zip', Carbon::parse($request['month'])->format('Y-m'));
        $zip->open($zip_name, \ZipArchive::CREATE);

        $contract_folder_name = 'Contrats de travail';
        $payslip_folder_name = 'Bulletins de versement';
        $zip->addEmptyDir($contract_folder_name);
        $zip->addEmptyDir($payslip_folder_name);

        foreach ($payslips as $payslip) {
            $contractPDF = PDF::loadView('files.contract', ['payslip' => $payslip]);
            $payslipPDF = PDF::loadView('files.payslip', ['payslip' => $payslip]);

            $zip->addFromString(
                sprintf('%s/%s', $contract_folder_name, $payslip->generateContractName()),
                $contractPDF->output()
            );
            $zip->addFromString(
                sprintf('%s/%s', $payslip_folder_name, $payslip->generatePayslipName()),
                $payslipPDF->output()
            );
        }

        $zip->close();

        return response()->download(public_path($zip_name), $zip_name, ['Content-Type' => 'application/zip'])
            ->deleteFileAfterSend();
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
