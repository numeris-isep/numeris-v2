<?php

namespace Tests\Feature\Address\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserIndex()
    {
        $this->json('GET', route('addresses.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'street',
                'zip_code',
                'city',
            ]]);
    }
}
