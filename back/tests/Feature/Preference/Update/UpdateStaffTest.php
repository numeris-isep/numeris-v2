<?php

namespace Tests\Feature\Preference\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffUpdatingPreference()
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
     * @group staff
     */
    public function testStaffUpdatingDeveloperPreference()
    {
        $preference = $this->activeDeveloperProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingAdministratorPreference()
    {
        $preference = $this->activeAdministratorProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingStaffPreference()
    {
        $preference = $this->activeStaffProvider()->preference;

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingStudentPreference()
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
}
