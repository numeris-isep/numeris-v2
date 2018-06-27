<?php

namespace Tests\Feature\User\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UdpateAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingUser()
    {
        $user_id = 1;

        $data = $db_data = [
            'email'                     => 'test@numeris-isep.fr',
            'password'                  => 'azerty',
            'username'                  => 'test',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
        ];
        // Add 'password_confirmation' data after init to avoid check on unknown column 'password_confirmation'
        $data['password_confirmation'] = 'azerty';

        $this->assertDatabaseMissing('users', $db_data);

        $this->json('PUT', route('users.update', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseMissing('users', $db_data);
    }
}
