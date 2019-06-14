<?php

namespace Tests\Feature\User\UpdateProfile;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateProfileAdministratorTest extends TestCaseWithAuth
{
    protected $username = Role::ADMINISTRATOR;

    /**
     * @group administrator
     */
    public function testAdministratorUpdatingHisOwnProfile()
    {
        $user = auth()->user(); // Own profile

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

        $data = array_merge($user_data, $address_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user_id' => $user->id]), $data)
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
     * @group administrator
     *
     * @dataProvider activeDeveloperProvider
     */
    public function testAdministratorUpdatingDeveloperProfile($developer)
    {
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

        $data = array_merge($user_data, $address_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $developer->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group administrator
     *
     * @dataProvider activeAdministratorProvider
     */
    public function testAdministratorUpdatingAdministratorProfile($administrator)
    {
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

        $data = array_merge($user_data, $address_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $administrator->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group administrator
     *
     * @dataProvider activeStaffProvider
     */
    public function testAdministratorUpdatingStaffProfile($staff)
    {
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

        $data = array_merge($user_data, $address_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $staff->id]), $data)
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
     * @group administrator
     *
     * @dataProvider activeStudentProvider
     */
    public function testAdministratorUpdatingStudentProfile($student)
    {
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

        $data = array_merge($user_data, $address_data);

        $this->assertDatabaseMissing('users', $user_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PATCH', route('users.update.profile', ['user' => $student->id]), $data)
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
