<?php

namespace Tests\Feature\Payslip\DownloadContract;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDownloadingContract()
    {
        $payslip = $this->clientAndProjectAndMissionAndConventionWithBillsProvider()['payslip'];

        $this->json('GET', route('payslips.download.contract', ['payslip_id' => $payslip->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertHeader('Content-Type', 'application/pdf');
    }
}
