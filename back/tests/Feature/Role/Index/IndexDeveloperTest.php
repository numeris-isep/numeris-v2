<?php

namespace Tests\Feature\Role\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingRoleIndex()
    {
        $this->json('GET', route('roles.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'nameFr',
                'hierarchy',
            ]]);
    }
}
