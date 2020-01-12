<?php

namespace Tests\Feature\User\UpdateActivated;

use App\Models\Role;
use App\Notifications\ActivateUserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
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
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        Notification::assertNothingSent();
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
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        Notification::assertNothingSent();
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
     * @group administrator
     */
    public function testAdministratorActivatingStudentWhoHasNotCompletedHisProfile()
    {
        $user = $this->activeStudentProvider();
        $user->update([
            'phone'                     => null,
            'birth_city'                => null,
            'nationality'               => null,
            'social_insurance_number'   => null,
            'bic'                       => null,
        ]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.profile_not_completed')]]);

        Notification::assertNothingSent();
    }

    /**
     * @group administrator
     */
    public function testAdministratorActivatingStudentWhoHasNotAcceptedTou()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.tou_not_accepted')]]);

        Notification::assertNothingSent();
    }

    /**
     * @group administrator
     */
    public function testAdministratorActivatingStudentWhoseEmailIsNotVerified()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.email_not_verified')]]);

        Notification::assertNothingSent();
    }

    /**
     * @group administrator
     */
    public function testAdministratorActivatingDeletedStudent()
    {
        $user = $this->activeStudentProvider();
        $user->update([
            'deleted_at' => now(),
        ]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.profile_deleted')]]);

        Notification::assertNothingSent();
    }
}
