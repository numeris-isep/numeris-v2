<?php

namespace Tests\Feature\Preference\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffUpdatingPreference()
    {
        $preference_id = 6; // Own preference

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
            'by_email'          => true,
            'by_push'           => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
                'byEmail',
                'byPush',
            ]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingDeveloperPreference()
    {
        $preference_id = 2; // Developer preference

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
            'by_email'          => true,
            'by_push'           => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingAdministratorPreference()
    {
        $preference_id = 4; // Administrator preference

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
            'by_email'          => true,
            'by_push'           => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingStaffPreference()
    {
        $preference_id = 6; // Staff preference

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
            'by_email'          => true,
            'by_push'           => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
                'byEmail',
                'byPush',
            ]);
    }

    /**
     * @group staff
     */
    public function testStaffUpdatingStudentPreference()
    {
        $preference_id = 8; // Student preference

        $data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true,
            'on_document'       => true,
            'by_email'          => true,
            'by_push'           => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'onNewMission',
                'onAcceptance',
                'onRefusal',
                'onDocument',
                'byEmail',
                'byPush',
            ]);
    }
}
