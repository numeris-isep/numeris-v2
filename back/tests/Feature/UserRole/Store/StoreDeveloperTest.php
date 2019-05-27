<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToDeveloper()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToAdministrator()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToStaff()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToStudent()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToDeveloper()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToAdministrator()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToStaff()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToStudent()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToDeveloper()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToAdministrator()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToStaff()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToStudent()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToDeveloper()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToAdministrator()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToStaff()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToStudent()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToAdministratorWithoutData()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'role_id' => [
                        trans('validation.required', ['attribute' => trans('validation.attributes.role_id')])
                    ]
                ]
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToAdministratorWrongValue()
    {
        $user_id = 8; // student user

        $data = [
            'role_id' => 'wrong-value',
        ];

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['role_id']);
    }
}
