<?php

namespace Tests\Feature\Mission\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingMissionShow()
    {
        $mission_id = 1;

        $this->json('GET', route('missions.show', ['mission_id' => $mission_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
                'address',
                'project',
            ]);
    }
}
