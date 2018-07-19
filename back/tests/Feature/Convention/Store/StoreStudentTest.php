<?php

namespace Tests\Feature\Convention\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentCreatingConvention()
    {
        $client_id = 1;

        $data = [
            'name' => '11-1111',
        ];

        $this->assertDatabaseMissing('conventions', $data);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseMissing('conventions', $data);
    }
}
