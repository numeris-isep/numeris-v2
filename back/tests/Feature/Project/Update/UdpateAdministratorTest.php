<?php

namespace Tests\Feature\Project\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingProject()
    {
        $project_id = 1;

        $data = [
            'client_id'     => 1,
            'convention_id' => 1,
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
                'startAt',
                'isPrivate',
                'moneyReceivedAt',
                'createdAt',
                'updatedAt',
                'client',
            ]);

        $this->assertDatabaseHas('projects', $data);
    }
}
