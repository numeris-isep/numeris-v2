<?php

namespace Tests\Feature\ProjectUser\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingProjectUserIndex()
    {
        $project = $this->privateProjectAndUserInProjectProvider()['project'];

        $this->json('GET', route('projects.users.index', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'preferenceId',
                'addressId',
                'activated',
                'touAccepted',
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
            ]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingPaginatedProjectUserIndex()
    {
        $project = $this->privateProjectAndUserInProjectProvider()['project'];

        $this->json('GET', route('projects.users.index', ['project_id' => $project->id, 'page' => 1]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'preferenceId',
                    'addressId',
                    'activated',
                    'touAccepted',
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
                ]],
                'links',
                'meta',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingPublicProjectUserIndex()
    {
        $project = $this->projectProvider();

        $this->json('GET', route('projects.users.index', ['project_id' => $project->id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
