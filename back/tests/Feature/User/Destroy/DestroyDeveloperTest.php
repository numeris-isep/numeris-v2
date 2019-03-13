<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
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

    /**
     * @group developer
     */
    public function testDeveloperDeletingHisOwnAccount()
    {
        $user_id = 2; // Own account
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