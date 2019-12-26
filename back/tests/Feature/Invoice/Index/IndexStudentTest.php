<?php

namespace Tests\Feature\Invoice\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingInvoiceIndex()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '1999'];

        $this->json('POST', route('invoices.index'), $year)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
