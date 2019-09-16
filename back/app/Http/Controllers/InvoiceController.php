<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade as PDF;

class InvoiceController extends Controller
{
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
