<?php

namespace Tests\Feature\User\Delete;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingUser()
    {
        $user_id = 1;
        $user = User::find($user_id);
        $address = $user->address;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('users.destroy', ['user' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
    }

    /**
     * @group staff
     */
    public function testStaffDeletingHisOwnAccount()
    {
        $user_id = 5; // Own account
        $user = User::find($user_id);

        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', route('users.destroy', ['user' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
    }
}
