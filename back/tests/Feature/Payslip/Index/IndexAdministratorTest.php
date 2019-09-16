<?php

namespace Tests\Feature\Payslip\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingPayslipIndex()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '2000'];

        $this->json('POST', route('payslips.index'), $year)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
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
