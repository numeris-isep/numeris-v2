<?php

namespace Tests\Feature\UserApplication\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingHisOwnApplicationIndex()
    {
        $user = auth()->user();

        $this->json('GET', route('users.applications.index', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
                'mission' => [
                    'address',
                    'project' => ['client']
                ],
            ]]);
    }

    /**
     * @group student
     */
    public function testStudentAccessingAnotherUserApplicationIndex()
    {
        $user = $this->activeStudentProvider();

        $this->json('GET', route('users.applications.index', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
