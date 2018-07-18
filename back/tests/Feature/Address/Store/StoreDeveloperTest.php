<?php

namespace Tests\Feature\Address\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingAddress()
    {
        $data = [
            'street' => '69 rue Balard',
            'zip_code' => 75015,
            'city' => 'Paris',
        ];

        $this->assertDatabaseMissing('addresses', $data);

        $this->json('POST', route('addresses.store'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'street',
                'zip_code',
                'city',
            ]);

        $this->assertDatabaseHas('addresses', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingAddressWithoutData()
    {
        $this->json('POST', route('addresses.store'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([ 'street', 'zip_code', 'city']);
    }
}
