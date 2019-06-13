<?php

namespace Tests\Feature\Project\Destroy;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     *
     * @dataProvider projectProvider
     */
    public function testStaffDeletingProjectWithoutBills($project)
    {
        $this->assertDatabaseHas('projects', $project->toArray());
        $this->assertTrue($project->missions->isEmpty());

        $this->json('DELETE', route('projects.destroy', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('projects', $project->toArray());
    }
}
