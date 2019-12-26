<?php

namespace Tests\Feature\User\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserShow()
    {
        $user = $this->activeUserProvider();

        $this->json('GET', route('users.show', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
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
                'address',
                'preference',
                'roles',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserShowWithUnknownUser()
    {
        $user_id = 0; // Unknown user

        $this->json('GET', route('users.show', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}
