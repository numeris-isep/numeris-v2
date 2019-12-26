<?php

namespace Tests\Feature\Mission\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentCreatingMission()
    {
        $mission_data = [
            'project_id'    => 1,
            'user_id'       => 1,
            'title'         => 'Mission de test',
            'description'   => 'Description de la mission de test',
            'start_at'      => '2018-01-01 08:00:00',
            'duration'      => 7,
            'capacity'      => 2,
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];
        $data = array_merge($mission_data, $address_data);

        $this->assertDatabaseMissing('missions', $mission_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('POST', route('missions.store'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('missions', $mission_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }
}
