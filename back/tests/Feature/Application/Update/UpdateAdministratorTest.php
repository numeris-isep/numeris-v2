<?php

namespace Tests\Feature\Application\Update;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingApplication()
    {
        $application_id = 1;

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'userId',
                'missionId',
                'type',
                'status',
                'createdAt',
                'updatedAt',
            ]);
    }
}
