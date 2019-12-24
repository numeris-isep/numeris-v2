<?php

namespace Tests\Feature\Payslip\Update;

use App\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffUpdatingPayslips()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'signed',
                'paid',
                'user',
                'month',
                'hourAmount',
                'grossAmount',
                'netAmount',
                'finalAmount',
                'subscriptionFee',
                'deductionAmount',
                'employerDeductionAmount',
                'deductions' => [[
                    'socialContribution',
                    'base',
                    'employeeRate',
                    'employerRate',
                    'employeeAmount',
                    'employerAmount'
                ]],
                'operations' => [['id', 'reference', 'startAt']],
                'clients' => [['id', 'name']],
                'createdAt',
                'updatedAt',
            ]]);
    }
}
