<?php

namespace Tests\Feature\Client\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientShow()
    {
        $client_id = 1;

        $this->json('GET', route('clients.show', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'address_id',
                'name',
                'reference',
                'created_at',
                'updated_at'
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientShowWithUnknownClient()
    {
        $client_id = 0; // Unknown client

        $this->json('GET', route('clients.show', ['client_id' => $client_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
