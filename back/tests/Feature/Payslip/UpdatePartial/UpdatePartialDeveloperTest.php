<?php

namespace Tests\Feature\Payslip\UpdatePartial;

use App\Models\Payslip;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdatePartialDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperPartiallyUpdatingPayslips()
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

    /**
     * @group developer
     */
    public function testDeveloperPartiallyUpdatingPayslipsWithoutData()
    {
        $this->json('PATCH', route('payslips.update.partial'), [])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['payslips']);
    }

    /**
     * @group developer
     */
    public function testDeveloperPartiallyUpdatingPayslipsWithoutAllData()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];
        $payslips = [['id' => $payslip['id']]];

        $this->json('PATCH', route('payslips.update.partial'), ['payslips' => $payslips])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['payslips.0.signed', 'payslips.0.paid']);
    }

    /**
     * @group developer
     */
    public function testDeveloperPartiallyUpdatingPayslipsWithWrongData()
    {
        $payslips = [[
            'id'        => 0,
            'signed'    => 'true',
            'paid'      => 'true',
        ]];

        $this->json('PATCH', route('payslips.update.partial'), ['payslips' => $payslips])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['payslips.0.signed', 'payslips.0.paid']);
    }
}
