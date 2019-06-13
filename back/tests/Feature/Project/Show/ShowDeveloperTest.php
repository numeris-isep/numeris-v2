<?php

namespace Tests\Feature\Project\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     *
     * @dataProvider projectAndMissionWithBillsProvider
     */
    public function testDeveloperAccessingProjectShow($project)
    {
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
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingProjectShowWithUnknownProject()
    {
        $project_id = 0; // Unknown project

        $this->json('GET', route('projects.show', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
