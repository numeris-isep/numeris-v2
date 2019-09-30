<?php

namespace Tests\Feature\User\UpdateActivated;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateActivatedAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;
    
    /**
     * @group administrator
     */
    public function testAdministratorActivatingDeveloper()
    {
        $user = $this->activeDeveloperProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group administrator
     */
    public function testAdministratorActivatingAdministrator()
    {
        $user = $this->activeAdministratorProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group administrator
     */
    public function testAdministratorActivatingStaff()
    {
        $user = $this->activeStaffProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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
            ]);
    }

    /**
     * @group administrator
     */
    public function testAdministratorActivatingStudent()
    {
        $user = $this->activeStudentProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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
            ]);
    }
}
