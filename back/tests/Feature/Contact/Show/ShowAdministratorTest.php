<?php

namespace Tests\Feature\Contact\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorAccessingContactShow()
    {
        $contact = $this->clientContactProvider();

        $this->json('GET', route('contacts.show', ['contact_id' => $contact->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'firstName',
                'lastName',
                'email',
                'phone',
            ]);
    }
}
