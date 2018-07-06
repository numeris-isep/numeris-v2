<?php

namespace Tests\Feature\Preference\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingPreferenceShow()
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

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserShowWithUnknownPreference()
    {
        $preference_id = 0; // Unknown preference

        $this->json('GET', route('preferences.show', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
