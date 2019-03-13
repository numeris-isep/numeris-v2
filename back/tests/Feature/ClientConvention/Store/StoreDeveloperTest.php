<?php

namespace Tests\Feature\ClientConvention\Store;
use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingConvention()
    {
        $client_id = 1;

        $data = [
            'name' => '11-1111',
        ];

        $this->assertDatabaseMissing('conventions', $data);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
            ]);

        $this->assertDatabaseHas('conventions', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithAlreadyUsedData()
    {
        $client_id = 1;

        $data = [
            'name' => Convention::find(1)->name, // Already used
        ];

        $this->assertDatabaseHas('conventions', $data);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithUnknownClient()
    {
        $client_id = 0; // Unknown client

        $data = [
            'name' => '11-1111',
        ];

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithoutData()
    {
        $client_id = 1;

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }
}
