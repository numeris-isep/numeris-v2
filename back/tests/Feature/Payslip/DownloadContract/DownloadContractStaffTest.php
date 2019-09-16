<?php

namespace Tests\Feature\Payslip\DownloadContract;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadContractStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffDownloadingContract()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.contract', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
