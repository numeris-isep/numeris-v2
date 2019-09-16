<?php

namespace Tests\Feature\Invoice\Download;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDownloadingInvoice()
    {
        $invoice = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['invoice'];

        $this->json('GET', route('invoices.download', ['invoice_id' => $invoice->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
