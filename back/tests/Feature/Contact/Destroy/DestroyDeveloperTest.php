<?php

namespace Tests\Feature\Contact\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperDeletingContact()
    {
        $contact = $this->clientContactProvider();

        $this->assertDatabaseHas('contacts', $contact->toArray());

        $this->json('DELETE', route('contacts.destroy', ['contact_id' => $contact->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('contacts', $contact->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownContact()
    {
        $contact_id = 0; // Unknown contact

        $this->json('DELETE', route('contacts.destroy', ['contact_id' => $contact_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);
    }
}
