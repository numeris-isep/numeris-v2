<?php

namespace Tests\Feature\User\Update;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithAllFields()
    {
        $user_id = 1;

        $data = $db_data = [
            'email'                     => 'test@numeris-isep.fr',
            'password'                  => 'azerty',
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
        // Add 'password_confirmation' data after init to avoid check on unknown column 'password_confirmation'
        $data['password_confirmation'] = 'azerty';

        $this->assertDatabaseMissing('users', $db_data);

        $this->json('PUT', route('users.update', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'preference_id',
                'address_id',
                'email',
                'username',
                'first_name',
                'last_name',
                'student_number',
                'promotion',
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

        $this->assertDatabaseHas('users', $db_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithMandatoryFieldsOnly()
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
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'email',
                'username',
                'first_name',
                'last_name',
            ]);

        $this->assertDatabaseHas('users', $db_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithAlreadyUsedData()
    {
        $user_id = 1;

        $data = $db_data = [
            'email'                     => 'developer@numeris-isep.fr', // Already used
            'password'                  => 'azerty',
            'username'                  => 'developer', // Already used
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
        ];
        // Add 'password_confirmation' data after init to avoid check on unknown column 'password_confirmation'
        $data['password_confirmation'] = 'azerty';

        $this->assertDatabaseMissing('users', $db_data);

        $this->json('PUT', route('users.update', ['user_id' => $user_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'email'     => ['La valeur du champ email est déjà utilisée.'],
                    'username' => ['La valeur du champ nom d\'utilisateur est déjà utilisée.'],
                ]
            ]);

        $this->assertDatabaseMissing('users', $db_data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUserWithoutData()
    {
        $user_id = 1;

        $this->json('PUT', route('users.update', ['user' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJson([
                'errors' => [
                    'password'      => ['Le champ mot de passe est obligatoire.'],
                    'first_name'    => ['Le champ prénom est obligatoire.'],
                    'last_name'     => ['Le champ nom est obligatoire.'],
                    'email'         => ['Le champ email est obligatoire.'],
                    'username'      => ['Le champ nom d\'utilisateur est obligatoire.'],
                ]
            ]);
    }
}
