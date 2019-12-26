<?php

namespace Tests\Feature\Mission\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateLockDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionLock()
    {
        $mission = $this->availableMissionProvider();

        $data = [
            'is_locked' => true,
        ];

        $this->json('PATCH', route('missions.update.lock', ['mission_id' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'isLocked',
                'reference',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownMissionLock()
    {
        $mission_id = 0; // Unknown mission

        $data = [
            'is_locked' => true,
        ];

        $this->json('PATCH', route('missions.update.lock', ['mission_id' => $mission_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionLockWithoutData()
    {
        $mission = $this->availableMissionProvider();

        $this->json('PATCH', route('missions.update.lock', ['mission_id' => $mission->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['is_locked']);
    }
}
