<?php

namespace Tests\Feature\Payslip\DownloadZip;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DownloadZipStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffDownloadingZip()
    {
        $month = '2000-01-01 00:00:00';

        $this->json('PUT', route('payslips.download.zip', ['month' => $month]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
