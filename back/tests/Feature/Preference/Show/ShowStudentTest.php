<?php

namespace Tests\Feature\Preference\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingPreferenceShow()
    {
        $preference_id = 1;

        $this->json('GET', route('preferences.show', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);
    }
}
