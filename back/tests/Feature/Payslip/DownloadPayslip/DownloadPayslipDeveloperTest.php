<?php

namespace Tests\Feature\Payslip\DownloadPayslip;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadPayslipDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDownloadingPayslip()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.payslip', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * @group developer
     */
    public function testDeveloperDownloadingPayslipWithUnknownPayslip()
    {
        $payslip_id = 0; // Unknown payslip

        $this->json('GET', route('payslips.download.payslip', ['payslip_id' => $payslip_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
                ->assertJson(['errors' => [trans('errors.404')]]);
    }
}
