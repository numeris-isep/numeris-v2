<?php

namespace Tests\Feature\Invoice\Download;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDownloadingInvoice()
    {
        $invoice = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['invoice'];

        $this->json('GET', route('invoices.download', ['invoice_id' => $invoice->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * @group developer
     */
    public function testDeveloperDownloadingInvoiceWithUnknownInvoice()
    {
        $invoice_id = 0; // Unknown invoice

        $this->json('GET', route('invoices.download', ['invoice_id' => $invoice_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
                ->assertJson(['errors' => [trans('api.404')]]);
    }
}
