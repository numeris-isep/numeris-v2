<?php

namespace Tests\Feature\User\Delete;

use App\Models\Preference;
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
        $preference = $user->preference;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertNotNull(Preference::find($preference->id));

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertNotNull(Preference::find($preference->id));
    }

    /**
     * @group staff
     */
    public function testStaffDeletingHisOwnAccount()
    {
        $user_id = 5; // Own account
        $user = User::find($user_id);
        $address = $user->address;
        $preference = $user->preference;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertNotNull(Preference::find($preference->id));

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
        $this->assertNull(Preference::find($preference->id));
    }
}
