<?php

namespace Tests\Feature\Payslip\DownloadContract;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDownloadingContract()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.contract', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * @group developer
     */
    public function testDeveloperDownloadingPayslipWithUnknownContract()
    {
        $payslip_id = 0; // Unknown payslip

        $this->json('GET', route('payslips.download.contract', ['payslip_id' => $payslip_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
                ->assertJson(['errors' => [trans('api.404')]]);
    }
}
