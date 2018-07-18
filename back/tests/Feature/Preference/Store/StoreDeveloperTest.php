<?php

namespace Tests\Feature\Preference\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingPreference()
    {
        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
        ];

        $this->json('POST', route('preferences.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'on_new_mission',
                'on_acceptance',
                'on_refusal',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingPreferenceWithoutData()
    {
        $this->json('POST', route('preferences.store'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'on_new_mission',
                'on_acceptance',
                'on_refusal'
            ]);
    }
}
