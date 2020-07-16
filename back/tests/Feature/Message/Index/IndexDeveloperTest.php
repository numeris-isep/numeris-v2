<?php

namespace Tests\Feature\Message\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group message
     */
    public function testDeveloperMessageIndex()
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
