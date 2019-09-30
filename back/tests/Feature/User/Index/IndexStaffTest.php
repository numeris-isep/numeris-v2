<?php

namespace Tests\Feature\User\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffAccesingUserIndex()
    {
        $this->json('GET', route('users.index'))
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
}
