<?php

namespace Tests\Feature\Contact\Destroy;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentDeletingContact()
    {
        $contact = $this->clientContactProvider();

        $this->assertDatabaseHas('contacts', $contact->toArray());

        $this->json('DELETE', route('contacts.show', ['contact_id' => $contact->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseHas('contacts', $contact->toArray());
    }
}
