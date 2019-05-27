<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToDeveloper()
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
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToAdministrator()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToStaff()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToStudent()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToDeveloper()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToAdministrator()
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
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToStaff()
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
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToStudent()
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
     * @group administrator
     */
    public function testAdministratorChangingStaffToDeveloper()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingStaffToAdministrator()
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
     * @group administrator
     */
    public function testAdministratorChangingStaffToStaff()
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
     * @group administrator
     */
    public function testAdministratorChangingStaffToStudent()
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
     * @group administrator
     */
    public function testAdministratorChangingStudentToDeveloper()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403'),
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingStudentToAdministrator()
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
     * @group administrator
     */
    public function testAdministratorChangingStudentToStaff()
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
     * @group administrator
     */
    public function testAdministratorChangingStudentToStudent()
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
}
