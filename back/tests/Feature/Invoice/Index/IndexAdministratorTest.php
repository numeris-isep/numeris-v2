<?php

namespace Tests\Feature\Invoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingInvoiceIndex()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '1999'];

        $this->json('POST', route('invoices.index'), $year)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'project',
                'grossAmount',
                'vatAmount',
                'finalAmount',
                'timeLimit',
                'details',
                'createdAt',
                'updatedAt',
            ]]);
    }
}
