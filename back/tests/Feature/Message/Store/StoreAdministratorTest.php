<?php

namespace Tests\Feature\Message\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group message
     */
    public function testAdministratorCreatingMessage()
    {
        $message = [
            'title'     => 'Test Store Administration',
            'content'   => "This is a test ",
            'link'      => 'https://numeris-isep.fr',
            'is_active' => false,
        ];

        $this->assertDatabaseMissing('messages', $message);

        $this->json('POST', route('messages.store'), $message)
            ->assertStatus(JsonResponse::HTTP_CREATED)
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

        $this->assertDatabaseHas('messages', $message);
    }
}
