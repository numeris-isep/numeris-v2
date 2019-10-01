<?php

namespace Tests\Feature\User\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccesingUserIndex()
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
                ]],
                'links',
                'meta',
            ]);
    }
}
