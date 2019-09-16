<?php

namespace Tests\Feature\Payslip\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingPayslipIndex()
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

    /**
     * @group developer
     */
    public function testDeveloperAccessingPayslipIndexWithOtherDate()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $year = ['year' => '1000'];

        $response = $this->json('POST', route('payslips.index'), $year)
            ->assertStatus(JsonResponse::HTTP_OK);

        $this->assertEquals([], json_decode($response->getContent(), true));
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingPayslipIndexWithoutDate()
    {
        $this->clientAndProjectAndMissionAndConventionWithBillsProvider();

        $this->json('POST', route('payslips.index'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['year']);
    }
}
