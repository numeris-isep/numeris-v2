<?php

namespace Tests\Feature\Invoice\Download;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffDownloadingInvoice()
    {
        $invoice = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['invoice'];

        $this->json('GET', route('invoices.download', ['invoice_id' => $invoice->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
