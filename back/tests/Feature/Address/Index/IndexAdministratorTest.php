<?php

namespace Tests\Feature\Address\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingUserIndex()
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
