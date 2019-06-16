<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Role;
use App\Models\Preference;
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

        $address = $user->address;
        $preference = $user->preference;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertNotNull(Preference::find($preference->id));

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('users', $user->toArray());
        $this->assertDatabaseMissing('addresses', $address->toArray());
        $this->assertNull(Preference::find($preference->id));
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownUser()
    {
        $user_id = 0; // Unknown user

        $this->json('DELETE', route('users.destroy', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
