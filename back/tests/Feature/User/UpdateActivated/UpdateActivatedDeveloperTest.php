<?php

namespace Tests\Feature\User\UpdateActivated;

use App\Models\Role;
use App\Notifications\ActivateUserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCaseWithAuth;

class UpdateActivatedDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperActivatingDeveloper()
    {
        $user = $this->activeDeveloperProvider();
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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperActivatingAdministrator()
    {
        $user = $this->activeAdministratorProvider();
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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperActivatingStaff()
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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperActivatingStudent()
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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperActivatingStudentWhoHasNotAcceptedTou()
    {
        $user = $this->activeStudentProvider();
        $user->update([
            'tou_accepted'  => false,
            'activated'     => false,
        ]);

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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperActivatingStudentWhoseEmailIsNotVerified()
    {
        $user = $this->activeStudentProvider();
        $user->update([
            'email_verified_at'     => null,
            'activated'             => false,
        ]);

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

        Notification::assertSentTo([$user], ActivateUserNotification::class);
    }

    /**
     * @group developer
     */
    public function testDeveloperActivatingDeletedStudent()
    {
        $user = $this->activeStudentProvider();
        $user->update([
            'deleted_at' => now(),
        ]);

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

        Notification::assertNothingSent();
    }
}
