<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Role;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDeletingUser()
    {
        $user = $this->activeUserProvider();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertNotNull(User::onlyTrashed()->find($user->id)->deleted_at);
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownUser()
    {
        $user_id = 0; // Unknown user

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}
