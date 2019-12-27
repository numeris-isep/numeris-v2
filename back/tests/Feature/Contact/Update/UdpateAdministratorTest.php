<?php

namespace Tests\Feature\Contact\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingContact()
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
}
