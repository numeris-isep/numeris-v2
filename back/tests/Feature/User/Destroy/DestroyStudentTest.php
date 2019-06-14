<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Preference;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     *
     * @dataProvider activeUserProvider
     */
    public function testStudentDeletingUser($user)
    {
        $address = $user->address;
        $preference = $user->preference;

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertNotNull(Preference::find($preference->id));

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseHas('users', $user->toArray());
        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertNotNull(Preference::find($preference->id));
    }

    /**
     * @group student
     */
    public function testStudentDeletingHisOwnAccount()
    {
        $user = auth()->user();
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
}
