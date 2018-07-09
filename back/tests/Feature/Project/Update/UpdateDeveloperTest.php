<?php

namespace Tests\Feature\Project\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProject()
    {
        $project_id = 1;

        $data = [
            'client_id'     => 1,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'step',
                'start_at',
                'is_private',
                'money_received_at',
                'created_at',
                'updated_at',
            ]);

        $this->assertDatabaseHas('projects', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectWithAlreadyUsedData()
    {
        $project_id = 1;

        $data = [
            'client_id'     => 1,
            'name'          => 'AS Connect Décembre 2018',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'name' => ['La valeur du champ nom est déjà utilisée.'],
                ]
            ]);

        $this->assertDatabaseMissing('projects', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithoutData()
    {
        $project_id = 1;

        $this->json('PUT', route('projects.update', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'client_id' => ['Le champ client est obligatoire.'],
                    'name'      => ['Le champ nom est obligatoire.'],
                    'start_at'  => ['Le champ date de début est obligatoire.'],
                ]
            ]);
    }
}
