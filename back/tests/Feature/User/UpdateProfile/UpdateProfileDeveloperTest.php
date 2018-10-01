<?php

namespace Tests\Feature\User\UpdateProfile;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateProfileDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingHisOwnProfile()
    {
        $user_id = 1; // Own profile

        $user_data = [
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
        $preference_data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true
        ];

        $data = array_merge($user_data, $address_data, $preference_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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

        $this->assertDatabaseHas('users', $user_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserProfileWithoutData()
    {
        $user_id = 1;

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'phone',
                'nationality',
                'birth_date',
                'birth_city',
                'social_insurance_number',
                'iban',
                'bic',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingDeveloperProfile()
    {
        $user_id = 2; // developer

        $user_data = [
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
        $preference_data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true
        ];

        $data = array_merge($user_data, $address_data, $preference_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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

        $this->assertDatabaseHas('users', $user_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingAdministratorProfile()
    {
        $user_id = 4; // administrator

        $user_data = [
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
        $preference_data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true
        ];

        $data = array_merge($user_data, $address_data, $preference_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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

        $this->assertDatabaseHas('users', $user_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingStaffProfile()
    {
        $user_id = 6; // staff

        $user_data = [
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
        $preference_data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true
        ];

        $data = array_merge($user_data, $address_data, $preference_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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

        $this->assertDatabaseHas('users', $user_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingStudentProfile()
    {
        $user_id = 8; // student

        $user_data = [
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
        $preference_data = [
            'on_new_mission'    => true,
            'on_acceptance'     => true,
            'on_refusal'        => true
        ];

        $data = array_merge($user_data, $address_data, $preference_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
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

        $this->assertDatabaseHas('users', $user_data);
        $this->assertDatabaseHas('addresses', $address_data);
    }
}
