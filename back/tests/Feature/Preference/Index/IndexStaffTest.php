<?php

namespace Tests\Feature\Preference\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingPreferenceIndex()
    {
        $this->json('GET', route('preferences.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'on_new_mission',
                'on_acceptance',
                'on_refusal',
            ]]);
    }
}
