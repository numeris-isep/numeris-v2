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
    use ClientProviderTrait;

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
                'user_id',
                'month',
                'gross_amount',
                'net_amount',
                'final_amount',
                'subscription_fee',
                'deduction_amount',
                'employer_deduction_amount',
                'deductions',
                'operations',
                'clients',
            ]]);
    }
}
