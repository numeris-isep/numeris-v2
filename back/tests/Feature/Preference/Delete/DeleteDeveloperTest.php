<?php

namespace Tests\Feature\Preference\Delete;

use App\Models\Preference;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingPreference()
    {
        $preference_id = 1;
        $preference = Preference::find($preference_id);
        $user = $preference->user;

        $this->assertDatabaseHas('preferences', $preference->toArray());
        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', route('preferences.destroy', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('preferences', $preference->toArray());
        $this->assertDatabaseHas('users', [
            'id'            => $user->id,
            'preference_id'    => null, // <-- onDelete('set null')
        ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingPreferenceWithUnknownPreference()
    {
        $preference_id = 0; // Unknown preference

        $this->json('DELETE', route('preferences.destroy', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
