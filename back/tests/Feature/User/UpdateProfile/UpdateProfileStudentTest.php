<?php

namespace Tests\Feature\User\UpdateProfile;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateProfileStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testAdministratorUpdatingHisOwnProfile()
    {
        $user_id = 7; // Own profile

        $data =  [
            'phone'                     => '01 23 45 67 89',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '1183573438099',
            'iban'                      => 'QUO IURE EST.',
            'bic'                       => 'ZVCRVZJGJ7F'
        ];

        $this->assertDatabaseMissing('users', $data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'phone',
                'nationality',
                'birth_date',
                'birth_city',
                'social_insurance_number',
                'iban',
                'bic',
                'created_at',
                'updated_at'
            ]);

        $this->assertDatabaseHas('users', $data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingDeveloperProfile()
    {
        $user_id = 2; // developer

        $data =  [
            'phone'                     => '01 23 45 67 89',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '1183573438099',
            'iban'                      => 'QUO IURE EST.',
            'bic'                       => 'ZVCRVZJGJ7F'
        ];

        $this->assertDatabaseMissing('users', $data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseMissing('users', $data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingAdministratorProfile()
    {
        $user_id = 4; // administrator

        $data =  [
            'phone'                     => '01 23 45 67 89',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '1183573438099',
            'iban'                      => 'QUO IURE EST.',
            'bic'                       => 'ZVCRVZJGJ7F'
        ];

        $this->assertDatabaseMissing('users', $data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseMissing('users', $data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingStaffProfile()
    {
        $user_id = 6; // staff

        $data =  [
            'phone'                     => '01 23 45 67 89',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '1183573438099',
            'iban'                      => 'QUO IURE EST.',
            'bic'                       => 'ZVCRVZJGJ7F'
        ];

        $this->assertDatabaseMissing('users', $data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseMissing('users', $data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingStudentProfile()
    {
        $user_id = 8; // student

        $data =  [
            'phone'                     => '01 23 45 67 89',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '1183573438099',
            'iban'                      => 'QUO IURE EST.',
            'bic'                       => 'ZVCRVZJGJ7F'
        ];

        $this->assertDatabaseMissing('users', $data);

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);

        $this->assertDatabaseMissing('users', $data);
    }
}
