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
     * @group developer
     */
    public function testDeveloperUpdatingUserProfileWithoutData()
    {
        $user_id = 1;

        $this->json('PATCH', route('users.update.profile', ['user' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'phone'                     => ['Le champ téléphone est obligatoire.'],
                    'nationality'               => ['Le champ nationalité est obligatoire.'],
                    'birth_date'                => ['Le champ date de naissance est obligatoire.'],
                    'birth_city'                => ['Le champ ville de naissance est obligatoire.'],
                    'social_insurance_number'   => ['Le champ numéro de sécurité sociale est obligatoire.'],
                    'iban'                      => ['Le champ iban est obligatoire.'],
                    'bic'                       => ['Le champ bic est obligatoire.'],
                ]
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingDeveloperProfile()
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
     * @group developer
     */
    public function testDeveloperUpdatingAdministratorProfile()
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
     * @group developer
     */
    public function testDeveloperUpdatingStaffProfile()
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
     * @group developer
     */
    public function testDeveloperUpdatingStudentProfile()
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
}
