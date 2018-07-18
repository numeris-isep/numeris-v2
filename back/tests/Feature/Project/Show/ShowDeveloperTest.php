<?php

namespace Tests\Feature\Project\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingProjectShow()
    {
        $project_id = 1;

        $this->json('GET', route('projects.show', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'name',
                'step',
                'start_at',
                'is_private',
                'money_received_at',
                'created_at',
                'updated_at',
                'client',
                'convention',
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
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
