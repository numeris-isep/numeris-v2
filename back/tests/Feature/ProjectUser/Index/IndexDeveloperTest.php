<?php

namespace Tests\Feature\ProjectUser\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingProjectUserIndex()
    {
        $project_id = 12; // Private project

        $this->json('GET', route('projects.users.index', ['project_id' => $project_id]))
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
        $project_id = 1; // Public project

        $this->json('GET', route('projects.users.index', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
