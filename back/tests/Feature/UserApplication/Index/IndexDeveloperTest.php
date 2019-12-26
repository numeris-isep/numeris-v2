<?php

namespace Tests\Feature\UserApplication\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserApplicationIndex()
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
     * @group developer
     */
    public function testDeveloperAccessingUnknownUserApplicationIndex()
    {
        $user_id = 0;

        $this->json('GET', route('users.applications.index', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}
