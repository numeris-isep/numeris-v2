<?php

namespace Tests\Feature\User\Delete;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingUser()
    {
        $user_id = 1;
        $user = User::find($user_id);
        $address = $user->address;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
    }

    /**
     * @group administrator
     */
    public function testDeveloperDeletingHisOwnAccount()
    {
        $user_id = 3; // Own account
        $user = User::find($user_id);
        $address = $user->address;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
    }
}
