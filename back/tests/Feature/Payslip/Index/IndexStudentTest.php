<?php

namespace Tests\Feature\Payslip\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingPayslipIndex()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '2000'];

        $this->json('POST', route('payslips.index'), $year)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
