<?php

namespace Tests\Feature\Contact\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorDeletingContact()
    {
        $contact = $this->clientContactProvider();

        $this->assertDatabaseHas('contacts', $contact->toArray());

        $this->json('DELETE', route('contacts.show', ['contact_id' => $contact->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('contacts', $contact->toArray());
    }
}
