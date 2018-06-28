<?php

namespace Tests\Feature\Address\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingAddressShow()
    {
        $address_id = 1;

        $this->json('GET', route('addresses.show', ['address_id' => $address_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'street',
                'zip_code',
                'city',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserShowWithUnknownAddress()
    {
        $address_id = 0; // Unknown address

        $this->json('GET', route('addresses.show', ['address_id' => $address_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => 'Resource not found'
            ]);
    }
}
