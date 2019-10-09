<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceRequest;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param InvoiceRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(InvoiceRequest $request)
    {
        $this->authorize('index', Invoice::class);

        $invoices = Invoice::findByYear($request['year'])->load('project', 'project.client');

        return response()->json(InvoiceResource::collection($invoices));
    }

    /**
     * Download a given invoice PDF.
     *
     * @param $payslip_id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function download($payslip_id)
    {
        /** @var Invoice $invoice */
        $invoice = Invoice::findOrFail($payslip_id);
        $this->authorize('download', $invoice);

        return PDF::loadView('files.invoice', ['invoice' => $invoice])
            ->download($invoice->generateFilename());
    }
}
