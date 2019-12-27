<?php

namespace Tests\Feature\Contact\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingContact()
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
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('contacts', $data);
    }
}
