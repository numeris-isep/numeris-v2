<?php

namespace Tests\Feature\User\Store;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffCreatingUser()
    {
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

        $this->json('POST', route('users.store'), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseMissing('users', $db_data);
    }
}
