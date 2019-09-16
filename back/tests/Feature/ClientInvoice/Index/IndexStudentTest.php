<?php

namespace Tests\Feature\ClientInvoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingClientInvoiceIndex()
    {
        $client = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['client'];

        $this->json('GET', route('clients.invoices.index', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
