<?php

namespace Tests\Feature\Preference\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingPreference()
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
     * @group administrator
     */
    public function testAdministratorUpdatingDeveloperPreference()
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
     * @group administrator
     */
    public function testAdministratorUpdatingAdministratorPreference()
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
     * @group administrator
     */
    public function testAdministratorUpdatingStaffPreference()
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
     * @group administrator
     */
    public function testAdministratorUpdatingStudentPreference()
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
