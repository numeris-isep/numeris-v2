<?php

namespace Tests\Feature\Payslip\UpdatePartial;

use App\Models\Role;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdatePartialAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorPartiallyUpdatingPayslips()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];
        $payslips = [[
            'id'        => $payslip['id'],
            'signed'    => true,
            'paid'      => true,
        ]];

        $response = $this->json('PATCH', route('payslips.update.partial'), ['payslips' => $payslips])
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
        $content = json_decode($response->getContent(), true)[0];

        $this->assertTrue($content['signed']);
        $this->assertTrue($content['paid']);
    }
}
