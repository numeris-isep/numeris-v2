<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToDeveloper()
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
     * @group developer
     */
    public function testDeveloperChangingDeveloperToAdministrator()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($developer->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToStaff()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($developer->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToStudent()
    {
        $developer = $this->activeDeveloperProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($developer->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($developer->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToDeveloper()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($administrator->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToAdministrator()
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
     * @group developer
     */
    public function testDeveloperChangingAdministratorToStaff()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($administrator->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingAdministratorToStudent()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($administrator->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($administrator->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToDeveloper()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($staff->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToAdministrator()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($staff->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStaffToStaff()
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
     * @group developer
     */
    public function testDeveloperChangingStaffToStudent()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($staff->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($staff->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToDeveloper()
    {
        $student = $this->activeStudentProvider();

        $role_id = 1; // developer
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($student->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToAdministrator()
    {
        $student = $this->activeStudentProvider();

        $role_id = 2; // administrator
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($student->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToStaff()
    {
        $student = $this->activeStudentProvider();

        $role_id = 3; // staff
        $role_name = Role::find($role_id)->name;

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertFalse($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJson([
                'id'    => $role_id,
                'name'  => $role_name,
            ]);

        $this->assertTrue($student->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToStudent()
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

    /**
     * @group developer
     */
    public function testDeveloperChangingDeveloperToAdministratorWithoutData()
    {
        $student = $this->activeStudentProvider();

        $role_id = 4; // student
        $role_name = Role::find($role_id)->name;

        $this->assertTrue($student->role()->name == $role_name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'role_id' => [
                        trans('validation.required', ['attribute' => trans('validation.attributes.role_id')])
                    ]
                ]
            ]);

        $this->assertTrue($student->role()->name == $role_name);
    }

    /**
     * @group developer
     */
    public function testDeveloperChangingStudentToAdministratorWrongValue()
    {
        $student = $this->activeStudentProvider();

        $data = [
            'role_id' => 'wrong-value',
        ];

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['role_id']);
    }
}
