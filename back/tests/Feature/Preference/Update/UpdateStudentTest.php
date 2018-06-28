<?php

namespace Tests\Feature\Preference\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentUpdatingPreference()
    {
        $preference_id = 1;
        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);
    }
}
