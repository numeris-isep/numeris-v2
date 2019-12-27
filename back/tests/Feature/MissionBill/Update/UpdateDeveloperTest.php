<?php

namespace Tests\Feature\MissionBill\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperCreatingMissionBill()
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

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionBill()
    {
        $project = $this->validatedProjectAndAvailableMissionProvider()['project'];
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, null, $project);
        $mission = $test_data['mission'];
        $application = $test_data['application'];
        $bill = $test_data['bill'];
        $rate = $test_data['rate'];

        $data = ['applications' => [[
            'application_id'    => $application->id,
            'bills'             => [[
                'id'        => $bill->id,
                'rate_id'   => $rate->id,
                'amount'    => 100,
            ]],
        ]]];

        $this->assertDatabaseHas('bills', [
            'id'        => $bill->id,
            'rate_id'   => $rate->id,
            'amount'    => $bill->amount,
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
            'id'        => $bill->id,
            'rate_id'   => $rate->id,
            'amount'    => 100,
        ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionBillWithoutData()
    {
        $mission = $this->availableMissionProvider();
        $data = [];

        $this->json('PUT', route('missions.bills.update', ['mission' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['applications']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionBillWithoutData2()
    {
        $mission = $this->availableMissionProvider();
        $data = ['applications' => [[]]];

        $this->json('PUT', route('missions.bills.update', ['mission' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['applications.0.application_id', 'applications.0.bills']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingMissionBillWithoutData3()
    {
        $project = $this->validatedProjectAndAvailableMissionProvider()['project'];
        $test_data = $this->clientAndProjectAndMissionAndConventionWithBillsProvider(null, null, $project);
        $mission = $test_data['mission'];
        $application = $test_data['application'];

        $data = ['applications' => [[
            'application_id'    => $application->id,
            'bills'             => [[]],
        ]]];

        $this->json('PUT', route('missions.bills.update', ['mission' => $mission->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['applications.0.bills.0.rate_id', 'applications.0.bills.0.amount']);
    }
}
