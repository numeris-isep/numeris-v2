<?php

namespace Tests\Feature\Message\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group message
     */
    public function testStudentUpdatingMessage()
    {
        $message = $this->messageProvider();

        $message_update = [
            'title'     => 'Test Update Student',
            'content'   => "This is a test ",
            'link'      => 'https://numeris-isep.fr',
            'is_active' => false,
        ];

        $this->assertDatabaseMissing('messages', $message_update);

        $this->json('PUT', route('messages.update', ['message_id' => $message->id]), $message_update)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('messages', $message_update);
    }
}
