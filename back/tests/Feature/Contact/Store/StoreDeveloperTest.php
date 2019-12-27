<?php

namespace Tests\Feature\Contact\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperCreatingContact()
    {
        $data = [
            'first_name'    => 'Test',
            'last_name'     => 'Test',
            'email'         => 'test@test.fr',
            'phone'         => '0123456789',
        ];

        $this->assertDatabaseMissing('contacts', $data);

        $this->json('POST', route('contacts.store'), $data)
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
    public function testDeveloperCreatingContactWithWrongData()
    {
        $data = [
            'first_name'    => 1,
            'last_name'     => 1,
            'email'         => 'test',
            'phone'         => '012345',
        ];

        $this->assertDatabaseMissing('contacts', $data);

        $this->json('POST', route('contacts.store'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'phone']);

        $this->assertDatabaseMissing('contacts', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingContactWithoutData()
    {
        $this->json('POST', route('contacts.store'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['first_name', 'last_name']);
    }
}
