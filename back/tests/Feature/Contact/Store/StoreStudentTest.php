<?php

namespace Tests\Feature\Contact\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentCreatingContact()
    {
        $data = [
            'first_name'    => 'Test',
            'last_name'     => 'Test',
            'email'         => 'test@test.fr',
            'phone'         => '0123456789',
        ];

        $this->assertDatabaseMissing('contacts', $data);

        $this->json('POST', route('contacts.store'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('contacts', $data);
    }
}
