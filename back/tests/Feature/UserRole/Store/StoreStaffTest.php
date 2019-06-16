<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToDeveloper()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($developer->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToAdministrator()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($developer->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToStaff()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($developer->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingDeveloperToStudent()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($developer->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToDeveloper()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($administrator->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToAdministrator()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($administrator->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToStaff()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($administrator->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingAdministratorToStudent()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($administrator->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToDeveloper()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($staff->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToAdministrator()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($staff->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToStaff()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($staff->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStaffToStudent()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($staff->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToDeveloper()
    {
        $student = $this->activeStudentProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($student->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToAdministrator()
    {
        $student = $this->activeStudentProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($student->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToStaff()
    {
        $student = $this->activeStudentProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertFalse($student->role()->name == $role_name);
    }

    /**
     * @group staff
     */
    public function testStaffChangingStudentToStudent()
    {
        $student = $this->activeStudentProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertTrue($student->role()->name == $role_name);
    }
}
