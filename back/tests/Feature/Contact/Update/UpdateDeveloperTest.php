<?php

namespace Tests\Feature\Contact\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperUpdatingContact()
    {
        $contact = $this->clientContactProvider();
        $data = [
            'first_name'    => 'Test',
            'last_name'     => 'Test',
            'email'         => 'test@test.fr',
            'phone'         => '0123456789',
        ];

        $this->assertDatabaseMissing('contacts', $data);

        $this->json('PUT', route('contacts.update', ['contact' => $contact->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'firstName',
                'lastName',
                'email',
                'phone',
            ]);

        $this->assertDatabaseHas('contacts', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingContactWithWrongData()
    {
        $contact = $this->clientContactProvider();
        $data = [
            'first_name'    => 1,
            'last_name'     => 1,
            'email'         => 'test',
            'phone'         => '012345',
        ];

        $this->assertDatabaseMissing('contacts', $data);

        $this->json('PUT', route('contacts.update', ['contact' => $contact->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'phone']);

        $this->assertDatabaseMissing('contacts', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingContactWithoutData()
    {
        $contact = $this->clientContactProvider();

        $this->json('PUT', route('contacts.update', ['contact' => $contact->id]), [])
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingContactWithUnknownContact()
    {
        $contact_id = 0; // Unknown contact
        $data = [
            'first_name'    => 'Test',
            'last_name'     => 'Test',
            'email'         => 'test@test.fr',
            'phone'         => '0123456789',
        ];

        $this->assertDatabaseMissing('contacts', $data);

        $this->json('PUT', route('contacts.update', ['contact' => $contact_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);

        $this->assertDatabaseMissing('contacts', $data);
    }
}
