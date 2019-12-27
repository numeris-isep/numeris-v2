<?php

namespace Tests\Feature\User\UpdateActivated;

use App\Models\Role;
use App\Notifications\ActivateUserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class UpdateActivatedStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffActivatingDeveloper()
    {
        $user = $this->activeDeveloperProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STAFF)]]);

        Notification::assertNothingSent();
    }

    /**
     * @group administrator
     */
    public function testStaffActivatingAdministrator()
    {
        $user = $this->activeAdministratorProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STAFF)]]);

        Notification::assertNothingSent();
    }

    /**
     * @group administrator
     */
    public function testStaffActivatingStaff()
    {
        $user = $this->activeStaffProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STAFF)]]);

        Notification::assertNothingSent();
    }

    /**
     * @group administrator
     */
    public function testStaffActivatingStudent()
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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }
}
