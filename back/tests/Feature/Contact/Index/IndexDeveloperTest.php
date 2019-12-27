<?php

namespace Tests\Feature\Contact\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingContactIndex()
    {
        $this->json('GET', route('contacts.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'firstName',
                'lastName',
                'email',
                'phone',
            ]]);
    }
}
