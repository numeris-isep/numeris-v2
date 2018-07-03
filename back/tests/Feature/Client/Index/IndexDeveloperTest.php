<?php

namespace Tests\Feature\Client\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingClientIndex()
    {
        $this->json('GET', route('clients.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'address_id',
                'name',
                'reference',
                'created_at',
                'updated_at'
            ]]);
    }
}
