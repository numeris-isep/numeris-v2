<?php

namespace App\Http\Controllers;

use App\Calculator\PayslipCalculator;
use App\Http\Requests\PayslipRequest;
use App\Http\Resources\PayslipResource;
use App\Mail\NewDocumentMail;
use App\Models\Payslip;
use App\Models\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

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
     * Count hour amounts for podium.
     *
     * @param PayslipRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexPodium(PayslipRequest $request)
    {
        $payslips = Payslip::findTopThree($request['month']);

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
     * Download a ZIP archive containing contracts and payslips of a given month
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

        $payslips = Payslip::findByMonth($request['month'])->get();
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

        foreach ($results as $result) {
            $payslips->add(
                Payslip::updateOrCreate(['user_id' => $result['user_id'], 'month' => $result['month']], $result)->load('user')
            );
        }

        $this->sendNewDocumentMail($payslips);

        return response()->json(PayslipResource::collection($payslips));
    }

    /**
     * Send an email only when the document was recently created
     * (we do not want to send an email each time we update payslips)
     *
     * @param Collection $payslips
     */
    private function sendNewDocumentMail(Collection $payslips)
    {
        try {
            $users = $payslips
                ->filter(function (Payslip $payslip) {
                    return $payslip->wasRecentlyCreated;
                })
                ->pluck('user')
                ->filter(function (User $user) {
                    return $user->preference->on_document;
                });

            Mail::to($users)->send(new NewDocumentMail());
        } catch (\Exception $exception) {}
    }

    /**
     * Update signed or paid attributes of given payslips
     *
     * @param PayslipRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updatePartial(PayslipRequest $request)
    {
        $this->authorize('update', Payslip::class);

        $payslips = collect();

        foreach ($request->toArray()['payslips'] as $data) {
            $payslip = Payslip::findOrFail($data['id']);

            $payslip->update([
                'signed'    => $data['signed'] ?? $payslip->signed,
                'paid'      => $data['paid'] ?? $payslip->paid,
            ]);
            $payslips->add($payslip->load('user'));
        }

        return response()->json(PayslipResource::collection($payslips));
    }
}
