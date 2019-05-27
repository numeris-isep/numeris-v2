<?php

namespace Tests\Feature\Preference\Update;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPreference()
    {
        $preference_id = 8; // Own preference

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
     * @group developer
     */
    public function testDeveloperUpdatingDeveloperPreference()
    {
        $preference_id = 3; // Developer preference

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
     * @group developer
     */
    public function testDeveloperUpdatingAdministratorPreference()
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
     * @group developer
     */
    public function testDeveloperUpdatingStaffPreference()
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
     * @group developer
     */
    public function testDeveloperUpdatingStudentPreference()
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
            'by_email'          => true,
            'by_push'           => true,
        ];

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]), $data)
//            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingPreferenceWithoutData()
    {
        $preference_id = 1;

        $this->json('PUT', route('preferences.update', ['preference_id' => $preference_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'on_new_mission',
                'on_acceptance',
                'on_refusal',
                'on_document',
                'by_email',
                'by_push',
            ]);
    }
}
