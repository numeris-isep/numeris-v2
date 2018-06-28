<?php

namespace Tests\Feature\Preference\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingPreferenceShow()
    {
        $preference_id = 1;

        $this->json('GET', route('preferences.show', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'on_new_mission',
                'on_acceptance',
                'on_refusal',
            ]);
    }
}
