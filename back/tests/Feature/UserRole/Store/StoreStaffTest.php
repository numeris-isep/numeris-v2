<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToDeveloper()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
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
     * @group staff
     */
    public function testStaffChangingDeveloperToAdministrator()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToStaff()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToStudent()
    {
        $user_id = 2; // developer user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToDeveloper()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToAdministrator()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToStaff()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToStudent()
    {
        $user_id = 4; // administrator user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToDeveloper()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToAdministrator()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToStaff()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToStudent()
    {
        $user_id = 6; // staff user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToDeveloper()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToAdministrator()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToStaff()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertFalse($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToStudent()
    {
        $user_id = 8; // student user
        $user = User::find($user_id);

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role' => $role_id,
        ];

        $this->assertTrue($user->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }
}
