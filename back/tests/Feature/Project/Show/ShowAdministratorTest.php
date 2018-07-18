<?php

namespace Tests\Feature\Project\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingProjectShow()
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
}
