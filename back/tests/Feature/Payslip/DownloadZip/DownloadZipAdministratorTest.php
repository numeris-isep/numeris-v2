<?php

namespace Tests\Feature\Payslip\DownloadZip;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadZipAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDownloadingZip()
    {
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.download.zip', ['month' => $month]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
