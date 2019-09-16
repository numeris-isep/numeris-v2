<?php

namespace Tests\Feature\Payslip\Update;

use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;
use Tests\Traits\ClientProviderTrait;
use Tests\Traits\UserProviderTrait;

class UpdateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingPayslips()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.update'), ['month' => $month])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
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
