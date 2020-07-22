<?php

namespace Tests\Feature\Message\Current;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class CurrentDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group message
     */
    public function testDeveloperMessageCurrent()
    {
        $message = $this -> messageActiveProvider();
        
        $this->json('GET', route('messages.current'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'title',
                'content',
                'link',
                'is_active',
                'created_at',
                'updated_at',
                'deleted_at',
            ]);
    }
}
