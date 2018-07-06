<?php

namespace Tests\Feature\Preference\Delete;

use App\Models\Preference;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingPreference()
    {
        $preference_id = 1;
        $preference = Preference::find($preference_id);
        $user = $preference->user;

        $this->assertDatabaseHas('preferences', $preference->toArray());
        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', route('preferences.destroy', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('preferences', $preference->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
    }
}
