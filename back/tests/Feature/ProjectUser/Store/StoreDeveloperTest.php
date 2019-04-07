<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAddingUserToProject()
    {
        $project_id = 12; // private project
        $user_id = 2;

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project_id]),
            ['user_id' => $user_id])
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'preferenceId',
                'addressId',
                'activated',
                'touAccepted',
                'subscriptionPaidAt',
                'email',
                'username',
                'firstName',
                'lastName',
                'studentNumber',
                'promotion',
                'schoolYear',
                'phone',
                'nationality',
                'birthDate',
                'birthCity',
                'socialInsuranceNumber',
                'iban',
                'bic',
                'createdAt',
                'updatedAt',
            ]);

        $this->assertDatabaseHas('project_user', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperAddingUserToPublicProject()
    {
        $project_id = 1; // public project
        $user_id = 2;

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project_id]),
            ['user_id' => $user_id])
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);

        $this->assertDatabaseMissing('project_user', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperAddingAlreadyAddedUserToProject()
    {
        $project_id = 12; // private project
        $user_id = 1; // already added user

        $data = [
            'project_id'    => $project_id,
            'user_id'       => $user_id,
        ];

        $this->assertDatabaseHas('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project_id]),
            ['user_id' => $user_id])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('project_user', $data);
    }
}
