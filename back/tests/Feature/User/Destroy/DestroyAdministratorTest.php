<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Role;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDeletingUser()
    {
        $user = $this->activeStudentProvider();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertNotNull(User::onlyTrashed()->find($user->id)->deleted_at);
    }

    /**
     * @group administrator
     */
    public function testAdministratorDeletingDeveloper()
    {
        $user = $this->activeDeveloperProvider();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::ADMINISTRATOR)]]);

        $this->assertNull(User::find($user->id)->deleted_at);
    }
}
