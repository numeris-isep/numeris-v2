<?php

namespace Tests\Feature\Preference\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateUpdateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingPreference()
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
     * @group student
     */
    public function testStudentUpdatingDeveloperPreference()
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
     * @group student
     */
    public function testStudentUpdatingAdministratorPreference()
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
     * @group student
     */
    public function testStudentUpdatingStaffPreference()
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
     * @group student
     */
    public function testStudentUpdatingStudentPreference()
    {
        $preference = $this->activeStudentProvider()->preference;

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
}
