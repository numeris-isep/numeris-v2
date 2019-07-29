<?php

namespace Tests\Feature\User\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingUser()
    {
        $user = $this->activeStudentProvider();

        $user_data = $db_data = [
            'email'                     => 'test@isep.fr',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'promotion'                 => '1991',
            'phone'                     => '01 23 45 67 89',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '1183573438099',
            'iban'                      => 'QUO IURE EST.',
            'bic'                       => 'ZVCRVZJGJ7F'
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azerty';

        $data = array_merge($user_data, $address_data);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('users.update', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }
}
