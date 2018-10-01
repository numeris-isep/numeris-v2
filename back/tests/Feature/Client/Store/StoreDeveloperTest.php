<?php

namespace Tests\Feature\Client\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingClient()
    {
        $data = [
            'name'      => 'AS Something',
            'reference' => '00-0000'
        ];

        $this->assertDatabaseMissing('clients', $data);

        $this->json('POST', route('clients.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'addressId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
                'address',
            ]);

        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingClientWithAlreadyUsedData()
    {
        $data = [
            'name'      => 'AS Connect', // Already used
            'reference' => '01-0001' // Already used
        ];

        $this->assertDatabaseHas('clients', $data);

        $this->json('POST', route('clients.store'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'reference']);

        $this->assertDatabaseHas('clients', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingClientWithoutData()
    {
        $this->json('POST', route('clients.store'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name', 'reference']);
    }
}
