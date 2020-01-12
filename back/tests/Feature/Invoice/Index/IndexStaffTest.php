<?php

namespace Tests\Feature\Invoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffAccessingInvoiceIndex()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '1999'];

        $this->json('POST', route('invoices.index'), $year)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'project',
                'hourAmount',
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
