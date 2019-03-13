<?php

namespace Tests\Feature\Application\Update;
use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplication()
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

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownApplication()
    {
        $application_id = 0; // Unknown application

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingApplicationWithoutData()
    {
        $application_id = 1;

        $this->json('PUT', route('applications.update', ['application_id' => $application_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'type',
                'status'
            ]);
    }
}
