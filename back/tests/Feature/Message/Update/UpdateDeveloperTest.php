<?php

namespace Tests\Feature\Message\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group message
     */
    public function testDeveloperUpdatingMessage()
    {
        $message = $this->messageProvider();

        $message_update = [
            'title'     => 'Test Update Developer',
            'content'   => "This is a test ",
            'link'      => 'https://numeris-isep.fr',
            'is_active' => false,
        ];

        $this->assertDatabaseMissing('messages', $message_update);

        $this->json('PUT', route('messages.update', ['message_id' => $message->id]), $message_update)
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

        $this->assertDatabaseHas('messages', $message_update);
    }
}
