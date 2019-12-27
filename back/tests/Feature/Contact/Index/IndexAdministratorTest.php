<?php

namespace Tests\Feature\Contact\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingContactIndex()
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
