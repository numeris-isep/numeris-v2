<?php

namespace Tests\Feature\Payslip\DownloadContract;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingHisOwnContract()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(auth()->user())['payslip'];

        $this->json('GET', route('payslips.download.contract', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * @group student
     */
    public function testStudentAccessingAnotherUserContract()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.payslip', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
