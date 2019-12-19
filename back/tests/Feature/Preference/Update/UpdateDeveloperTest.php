<?php

namespace Tests\Feature\Preference\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPreference()
    {
        $preference = auth()->user()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingDeveloperPreference()
    {
        $preference = $this->activeDeveloperProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingAdministratorPreference()
    {
        $preference = $this->activeAdministratorProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingStaffPreference()
    {
        $preference = $this->activeStaffProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingStudentPreference()
    {
        $preference = $this->activeStudentProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownPreference()
    {
        $preference_id = 0; // Unknown preference

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPreferenceWithoutData()
    {
        $preference = $this->activeUserProvider()->preference;

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'on_new_mission',
                'on_acceptance',
                'on_refusal',
                'on_document',
            ]);
    }
}
