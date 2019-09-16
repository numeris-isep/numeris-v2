<?php

namespace Tests\Feature\ClientInvoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientInvoiceIndex()
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

    /**
     * @group developer
     */
    public function testDeveloperAccessingUnknownClientInvoiceIndex()
    {
        $client_id = 0; // Unknown client

        $this->json('GET', route('clients.invoices.index', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
