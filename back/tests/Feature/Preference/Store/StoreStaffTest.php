<?php

namespace Tests\Feature\Preference\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffCreatingPreference()
    {
        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
        ];

        $this->json('POST', route('preferences.store'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);
    }
}
