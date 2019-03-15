<?php

namespace Tests\Feature\Project\Update;

use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdatePaymentDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectPayment()
    {
        $project_id = 1;

        $data = [
            'money_received_at' => '2018-01-01 00:00:00'
        ];

        $this->json('PATCH', route('projects.update.payment', ['project_id' => $project_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'step',
                'startAt',
                'isPrivate',
                'moneyReceivedAt',
                'createdAt',
                'updatedAt',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingProjectPaymentWithoutData()
    {
        $project_id = 1;

        $this->json('PATCH', route('projects.update.payment', ['project_id' => $project_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['money_received_at']);
    }
}
