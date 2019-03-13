<?php

namespace Tests\Feature\Application\Update;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateUpdateStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentUpdatingApplication()
    {
        $application_id = 1;

        $data = [
            'status' => Application::ACCEPTED,
        ];

        $this->json('PUT', route('applications.update', ['application_id' => $application_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}
