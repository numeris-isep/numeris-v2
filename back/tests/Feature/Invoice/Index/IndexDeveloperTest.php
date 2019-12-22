<?php

namespace Tests\Feature\Invoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingInvoiceIndex()
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

    /**
     * @group developer
     */
    public function testDeveloperAccessingInvoiceIndexWithOtherDate()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '1000'];

        $response = $this->json('POST', route('invoices.index'), $year)
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals([], json_decode($response->getContent(), true));
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingInvoiceIndexWithoutDate()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();

        $this->json('POST', route('invoices.index'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['year']);
    }
}
