<?php

namespace Tests\Feature\Payslip\Update;

use App\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingPayslips()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
