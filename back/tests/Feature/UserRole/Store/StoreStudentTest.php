<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group administrator
     */
    public function testStudentChangingDeveloperToDeveloper()
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
                'error' => 'Forbidden',
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingDeveloperToAdministrator()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingDeveloperToStaff()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingDeveloperToStudent()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingAdministratorToDeveloper()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingAdministratorToAdministrator()
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
                'error' => 'Forbidden'
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingAdministratorToStaff()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingAdministratorToStudent()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStaffToDeveloper()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStaffToAdministrator()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStaffToStaff()
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
                'error' => 'Forbidden'
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStaffToStudent()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStudentToDeveloper()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStudentToAdministrator()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStudentToStaff()
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
                'error' => 'Forbidden',
            ]);

        $this->assertFalse($user->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testStudentChangingStudentToStudent()
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
                'error' => 'Forbidden'
            ]);

        $this->assertTrue($user->role()->name == $role_name);
    }
}
