<?php

namespace Tests\Feature\ProjectUser\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAddingUserToProject()
    {
        $test_data = $this->privateProjectAndUserProvider();
        $project = $test_data['project'];
        $user = $test_data['user'];

        $data = [
            'project_id'    => $project->id,
            'user_id'       => $user->id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project->id]),
            ['user_id' => $user->id])
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'preferenceId',
                'addressId',
                'activated',
                'touAccepted',
                'emailVerifiedAt',
                'subscriptionPaidAt',
                'email',
                'firstName',
                'lastName',
                'promotion',
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
        $test_data = $this->publicProjectAndUserProvider();
        $project = $test_data['project'];
        $user = $test_data['user'];

        $data = [
            'project_id'    => $project->id,
            'user_id'       => $user->id,
        ];

        $this->assertDatabaseMissing('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project->id]),
            ['user_id' => $user->id])
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);

        $this->assertDatabaseMissing('project_user', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperAddingUserAlreadyInProjectToProject()
    {
        $test_data = $this->privateProjectAndUserInProjectProvider();
        $project = $test_data['project'];
        $user = $test_data['user'];

        $data = [
            'project_id'    => $project->id,
            'user_id'       => $user->id,
        ];

        $this->assertDatabaseHas('project_user', $data);

        $this->json(
            'POST',
            route('projects.users.store', ['project_id' => $project->id]),
            ['user_id' => $user->id])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseHas('project_user', $data);
    }
}
