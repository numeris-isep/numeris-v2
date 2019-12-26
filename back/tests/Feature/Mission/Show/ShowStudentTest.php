<?php

namespace Tests\Feature\Mission\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingMissionShow()
    {
        $mission = $this->availableMissionProvider();

        $this->json('GET', route('missions.show', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
