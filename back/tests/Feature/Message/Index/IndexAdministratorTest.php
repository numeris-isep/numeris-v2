<?php

namespace Tests\Feature\Message\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group message
     */
    public function testAdministratorMessageIndex()
    {
        $this->json('GET', route('messages.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'title',
                'content',
                'link',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ]]);
    }
}
