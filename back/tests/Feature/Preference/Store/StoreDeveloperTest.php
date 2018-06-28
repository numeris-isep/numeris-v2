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
            ->assertJson([
                'errors' => [
                    'on_new_mission'    => ['Le champ nouvelle mission disponible est obligatoire.'],
                    'on_acceptance'     => ['Le champ accepté sur une mission est obligatoire.'],
                    'on_refusal'        => ['Le champ refusé sur une mission est obligatoire.'],
                ]
            ]);
    }
}
