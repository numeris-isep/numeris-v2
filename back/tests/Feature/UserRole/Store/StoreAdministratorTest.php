<?php

namespace Tests\Feature\UserRole\Store;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToDeveloper()
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
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        $this->assertTrue($developer->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToAdministrator()
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
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        $this->assertFalse($developer->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToStaff()
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
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        $this->assertFalse($developer->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingDeveloperToStudent()
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
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        $this->assertFalse($developer->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToDeveloper()
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
            ->assertJson(['errors' => [trans('errors.roles.superior')]]);

        $this->assertFalse($administrator->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToAdministrator()
    {
        $administrator = $this->activeAdministratorProvider();

        $role_id = 2; // administrator
        $role = Role::find($role_id);

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($administrator->role()->name == $role->name);

        $this->json('POST', route('users.roles.store', ['user_id' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.same', ['role' => $role->name_fr])]]);

        $this->assertTrue($administrator->role()->name == $role->name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToStaff()
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
     * @group administrator
     */
    public function testAdministratorChangingAdministratorToStudent()
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
     * @group administrator
     */
    public function testAdministratorChangingStaffToDeveloper()
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
            ->assertJson(['errors' => [trans('errors.roles.superior')]]);

        $this->assertFalse($staff->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingStaffToAdministrator()
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
     * @group administrator
     */
    public function testAdministratorChangingStaffToStaff()
    {
        $staff = $this->activeStaffProvider();

        $role_id = 3; // staff
        $role = Role::find($role_id);

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($staff->role()->name == $role->name);

        $this->json('POST', route('users.roles.store', ['user_id' => $staff->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.same', ['role' => $role->name_fr])]]);

        $this->assertTrue($staff->role()->name == $role->name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingStaffToStudent()
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
     * @group administrator
     */
    public function testAdministratorChangingStudentToDeveloper()
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
            ->assertJson(['errors' => [trans('errors.roles.superior')]]);

        $this->assertFalse($student->role()->name == $role_name);
    }

    /**
     * @group administrator
     */
    public function testAdministratorChangingStudentToAdministrator()
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
     * @group administrator
     */
    public function testAdministratorChangingStudentToStaff()
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
     * @group administrator
     */
    public function testAdministratorChangingStudentToStudent()
    {
        $student = $this->activeStudentProvider();

        $role_id = 4; // student
        $role = Role::find($role_id);

        $data = [
            'role_id' => $role_id,
        ];

        $this->assertTrue($student->role()->name == $role->name);

        $this->json('POST', route('users.roles.store', ['user_id' => $student->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.same', ['role' => $role->name_fr])]]);

        $this->assertTrue($student->role()->name == $role->name);
    }
}
