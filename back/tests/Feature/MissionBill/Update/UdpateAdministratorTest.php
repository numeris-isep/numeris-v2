<?php

namespace Tests\Feature\MissionBill\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingMissionBill()
    {
        $project = $this->validatedProjectAndAvailableMissionProvider()['project'];
        $test_data = $this->clientAndProjectAndMissionAndConventionProvider(null, null, $project);
        $mission = $test_data['mission'];
        $application = $test_data['application'];
        $rate = $test_data['rate'];

        $data = ['applications' => [[
            'application_id'    => $application->id,
            'bills'             => [[
                'id'        => null,
                'rate_id'   => $rate->id,
                'amount'    => 100,
            ]],
        ]]];

        $this->assertDatabaseMissing('bills', [
            'rate_id'   => $rate->id,
            'amount'    => 10,
        ]);

        $this->json('PUT', route('missions.bills.update', ['mission' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
                'bills',
            ]]);

        $this->assertDatabaseHas('bills', [
            'rate_id'   => $rate->id,
            'amount'    => 100,
        ]);
    }
}
