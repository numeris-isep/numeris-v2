<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Role;
use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffDeletingUser()
    {
        $user = $this->activeUserProvider();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.roles.' . Role::STAFF)]]);

        $this->assertNull($user->deleted_at);
    }

    /**
     * @group staff
     */
    public function testStaffDeletingHisOwnAccount()
    {
        $user = auth()->user();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertNotNull(User::onlyTrashed()->find($user->id)->deleted_at);
    }
}
