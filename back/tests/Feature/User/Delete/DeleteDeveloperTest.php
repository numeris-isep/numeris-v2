<?php

namespace Tests\Feature\User\Delete;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingUser()
    {
        $user_id = 2;
        $user = User::find($user_id);
        $address = $user->address;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingHisOwnAccount()
    {
        $user_id = 1; // Own account
        $user = User::find($user_id);
        $address = $user->address;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUserWithUnknownUser()
    {
        $user_id = 0; // Unknown user

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
