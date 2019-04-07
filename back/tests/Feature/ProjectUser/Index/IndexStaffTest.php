<?php

namespace Tests\Feature\ProjectUser\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingProjectUserIndex()
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
                    'roles',
                ]],
                'links',
                'meta',
            ]);
    }
}
