<?php

namespace Tests\Feature\Client\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccesingClientIndex()
    {
        $this->json('GET', route('clients.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'addressId',
                'name',
                'reference',
                'createdAt',
                'updatedAt',
            ]]);
    }
}