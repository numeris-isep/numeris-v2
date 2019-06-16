<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentChangingDeveloperToDeveloper()
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
     * @group student
     */
    public function testStudentChangingDeveloperToAdministrator()
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
     * @group student
     */
    public function testStudentChangingDeveloperToStaff()
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
     * @group student
     */
    public function testStudentChangingDeveloperToStudent()
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
     * @group student
     */
    public function testStudentChangingAdministratorToDeveloper()
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
     * @group student
     */
    public function testStudentChangingAdministratorToAdministrator()
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
     * @group student
     */
    public function testStudentChangingAdministratorToStaff()
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
     * @group student
     */
    public function testStudentChangingAdministratorToStudent()
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
     * @group student
     */
    public function testStudentChangingStaffToDeveloper()
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
     * @group student
     */
    public function testStudentChangingStaffToAdministrator()
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
     * @group student
     */
    public function testStudentChangingStaffToStaff()
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
     * @group student
     */
    public function testStudentChangingStaffToStudent()
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
     * @group student
     */
    public function testStudentChangingStudentToDeveloper()
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
     * @group student
     */
    public function testStudentChangingStudentToAdministrator()
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
     * @group student
     */
    public function testStudentChangingStudentToStaff()
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
     * @group student
     */
    public function testStudentChangingStudentToStudent()
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
