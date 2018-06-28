<?php

namespace Tests\Feature\Preference\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPreference()
    {
        $preference_id = 1;
        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
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
    public function testDeveloperUpdatingPreferenceWithoutData()
    {
        $preference_id = 1;
        $data = [];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'on_new_mission'    => ['Le champ nouvelle mission disponible est obligatoire.'],
                    'on_acceptance'     => ['Le champ accepté sur une mission est obligatoire.'],
                    'on_refusal'        => ['Le champ refusé sur une mission est obligatoire.'],
                ]
            ]);
    }
}
