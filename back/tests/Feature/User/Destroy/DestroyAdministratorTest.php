<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider activeUserProvider
     */
    public function testAdministratorDeletingUser()
    {
        $user_id = 1;
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
