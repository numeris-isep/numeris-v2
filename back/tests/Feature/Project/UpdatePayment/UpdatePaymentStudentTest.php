<?php

namespace Tests\Feature\Project\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdatePaymentStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingProjectPayment()
    {
        $project = $this->projectProvider();

        $data = [
            'money_received_at'     => '2018-01-01 00:00:00',
        ];

        $this->json('PATCH', route('projects.update.payment', ['project_id' => $project->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
