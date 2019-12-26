<?php

namespace Tests\Feature\Payslip\DownloadZip;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadZipDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDownloadingZip()
    {
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.download.zip', ['month' => $month]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
