<?php

namespace Tests\Feature\User\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     *
     * @dataProvider activeStudentProvider
     */
    public function testDeveloperUpdatingUserWithAllFields($user)
    {
        $user_data = $db_data = [
            'email'                     => 'test@numeris-isep.fr',
            'username'                  => 'test',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'student_number'            => 1000,
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
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'preferenceId',
                'addressId',
                'activated',
                'touAccepted',
                'subscriptionPaidAt',
                'email',
                'username',
                'firstName',
                'lastName',
                'studentNumber',
                'promotion',
                'phone',
                'nationality',
                'birthDate',
                'birthCity',
                'socialInsuranceNumber',
                'iban',
                'bic',
                'createdAt',
                'updatedAt',
            ]);

        $this->assertDatabaseHas('users', $db_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     *
     * @dataProvider activeUserProvider
     */
    public function testDeveloperUpdatingUserWithAlreadyUsedData($user)
    {
        $user_data = $db_data = [
            'email'                     => 'developer@numeris-isep.fr', // Already used
            'username'                  => 'developer', // Already used
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'student_number'            => 1000,
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
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email', 'username']);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group developer
     *
     * @dataProvider activeUserProvider
     */
    public function testDeveloperUpdatingUserWithoutData($user)
    {
        $this->json('PUT', route('users.update', ['user' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'password', 'first_name', 'last_name',
                'email', 'username', 'phone',
                'nationality', 'birth_date', 'birth_city',
                'social_insurance_number', 'iban', 'bic',
                'street', 'zip_code', 'city',
            ]);
    }
}
