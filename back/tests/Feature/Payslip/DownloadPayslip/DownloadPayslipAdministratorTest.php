<?php

namespace Tests\Feature\Payslip\DownloadPayslip;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadPayslipAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDownloadingPayslip()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.payslip', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
