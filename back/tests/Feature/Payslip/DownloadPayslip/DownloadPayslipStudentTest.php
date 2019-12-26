<?php

namespace Tests\Feature\Payslip\DownloadPayslip;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadPayslipStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentDownloadingHisOwnPayslip()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(auth()->user())['payslip'];

        $this->json('GET', route('payslips.download.payslip', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * @group student
     */
    public function testStudentDownloadingAnotherUserPayslip()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.payslip', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
