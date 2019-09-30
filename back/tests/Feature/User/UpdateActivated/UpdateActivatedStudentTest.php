<?php

namespace Tests\Feature\User\UpdateActivated;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateActivatedStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentActivatingDeveloper()
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
     * @group student
     */
    public function testStudentActivatingAdministrator()
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
     * @group student
     */
    public function testStudentActivatingStaff()
    {
        $user = $this->activeStaffProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group student
     */
    public function testStudentActivatingStudent()
    {
        $user = $this->activeStudentProvider();
        $user->update(['activated' => false]);

        $data = [
            'activated' => true
        ];

        $this->json('PATCH', route('users.update.activated', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
