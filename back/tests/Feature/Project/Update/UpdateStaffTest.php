<?php

namespace Tests\Feature\Project\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     *
     * @dataProvider conventionAndProjectProvider
     */
    public function testStaffUpdatingProject($convention, $project)
    {
        $data = [
            'client_id'     => $convention->client->id,
            'convention_id' => $convention->id,
            'name'          => 'Projet de test',
            'start_at'      => now()->toDateString(),
            'is_private'    => false,
        ];

        $this->assertDatabaseMissing('projects', $data);

        $this->json('PUT', route('projects.update', ['project_id' => $project->id]), $data)
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
                'missionsCount',
                'usersCount',
            ]);

        $this->assertDatabaseHas('projects', $data);
    }
}
