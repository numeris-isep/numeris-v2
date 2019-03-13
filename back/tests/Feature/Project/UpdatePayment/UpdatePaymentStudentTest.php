<?php

namespace Tests\Feature\Project\Update;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdatePaymentStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentUpdatingProjectPayment()
    {
        $project_id = 1;

        $data = [
            'money_received_at'     => '2018-01-01 00:00:00',
        ];

        $this->json('PATCH', route('projects.update.payment', ['project_id' => $project_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}