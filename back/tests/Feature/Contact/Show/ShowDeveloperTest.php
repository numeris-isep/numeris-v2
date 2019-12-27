<?php

namespace Tests\Feature\Contact\Show;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperAccessingContactShow()
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

    /**
     * @group developer
     */
    public function testDeveloperAccessingContactShowWithUnknownContact()
    {
        $contact_id = 0; // Unknown contact

        $this->json('GET', route('contacts.show', ['contact_id' => $contact_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
                ->assertJson(['errors' => [trans('errors.404')]]);
    }
}
