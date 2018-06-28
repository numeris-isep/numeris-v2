<?php

namespace Tests\Feature\Preference\Delete;

use App\Models\Preference;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingPreference()
    {
        $preference_id = 1;
        $preference = Preference::find($preference_id);
        $user = $preference->user;

        $this->assertDatabaseHas('preferences', $preference->toArray());
        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', route('preferences.destroy', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseHas('preferences', $preference->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
    }
}
