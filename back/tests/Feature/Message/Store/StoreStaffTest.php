<?php

namespace Tests\Feature\Message\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group message
     */
    public function testStaffCreatingMessage()
    {
        $message = [
            'title'     => 'Test Store Staff',
            'content'   => "This is a test ",
            'link'      => 'https://numeris-isep.fr',
            'is_active' => false,
        ];

        $this->assertDatabaseMissing('messages', $message);

        $this->json('POST', route('messages.store'), $message)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('messages', $message);
    }
}
