<?php

namespace Tests\Feature\Payslip\UpdatePartial;

use App\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdatePartialStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingPartiallyPayslips()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];
        $payslips = [[
            'id'        => $payslip['id'],
            'signed'    => true,
            'paid'      => true,
        ]];

        $this->json('PATCH', route('payslips.update.partial'), ['payslips' => $payslips])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
