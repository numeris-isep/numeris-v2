<?php

namespace Tests\Feature\Invoice\Download;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentDownloadingInvoice()
    {
        $invoice = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(auth()->user())['invoice'];

        $this->json('GET', route('invoices.download', ['invoice_id' => $invoice->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
