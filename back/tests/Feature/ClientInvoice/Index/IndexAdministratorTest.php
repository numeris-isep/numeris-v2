<?php

namespace Tests\Feature\ClientInvoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingClientInvoiceIndex()
    {
        $client = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['client'];

        $this->json('GET', route('clients.invoices.index', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'project',
                'grossAmount',
                'vatAmount',
                'finalAmount',
                'details' => [[
                    'bills' => [[
                        'rate',
                        'hours',
                        'amount',
                        'total',
                    ]],
                    'title',
                    'startAt',
                    'reference',
                ]],
            ]]);
    }
}
