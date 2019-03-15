<?php

namespace Tests\Feature\Project\Store;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingProject()
    {
        $data = [
            'client_id'     => 1,
            'convention_id' => 1,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('POST', route('projects.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'step',
                'startAt',
                'isPrivate',
                'moneyReceivedAt',
                'createdAt',
                'updatedAt',
            ]);

        $this->assertDatabaseHas('projects', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingProjectWithAlreadyUsedData()
    {
        $data = [
            'client_id'     => 1,
            'name'          => 'AS Connect Décembre 2018', // Already used
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('POST', route('projects.store'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);

        $this->assertDatabaseMissing('projects', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingProjectWithoutData()
    {
        $this->json('POST', route('projects.store'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['client_id', 'name', 'start_at']);
    }
}
