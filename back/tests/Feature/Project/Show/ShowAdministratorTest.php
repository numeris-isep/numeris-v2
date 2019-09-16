<?php

namespace Tests\Feature\Project\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingProjectShow()
    {
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider();
        $project = $test_data['project'];

        $this->json('GET', route('projects.show', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
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
                'client',
                'convention',
                'missions',
                'invoice',
            ]);
    }
}
