<?php

namespace Tests\Feature\User\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingStudentWithAllFields()
    {
        $user = $this->activeStudentProvider();

        $user_data = $db_data = [
            'email'                     => 'test@isep.fr',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'promotion'                 => now()->addYear()->year,
            'phone'                     => '0123456789',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '118357343809929',
            'iban'                      => 'QUOIUREESTTEN93',
            'bic'                       => 'ZVCRVZJG'
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azertyuiop';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('users.update', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingStaffWithAllFields()
    {
        $user = $this->activeStaffProvider();

        $user_data = $db_data = [
            'email'                     => 'test@isep.fr',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'promotion'                 => now()->addYear()->year,
            'phone'                     => '0123456789',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '118357343809929',
            'iban'                      => 'QUOIUREESTTEN93',
            'bic'                       => 'ZVCRVZJG'
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azertyuiop';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('users.update', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingAdministratorWithAllFields()
    {
        $user = $this->activeAdministratorProvider();

        $user_data = $db_data = [
            'email'                     => 'test@isep.fr',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'promotion'                 => now()->addYear()->year,
            'phone'                     => '0123456789',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '118357343809929',
            'iban'                      => 'QUOIUREESTTEN93',
            'bic'                       => 'ZVCRVZJG'
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azertyuiop';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('users.update', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group student
     */
    public function testStudentUpdatingDeveloperWithAllFields()
    {
        $user = $this->activeDeveloperProvider();

        $user_data = $db_data = [
            'email'                     => 'test@isep.fr',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'promotion'                 => now()->addYear()->year,
            'phone'                     => '0123456789',
            'nationality'               => 'Française',
            'birth_date'                => '2001-06-13 09:50:16',
            'birth_city'                => 'Paris',
            'social_insurance_number'   => '118357343809929',
            'iban'                      => 'QUOIUREESTTEN93',
            'bic'                       => 'ZVCRVZJG'
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azertyuiop';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('PUT', route('users.update', ['user_id' => $user->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }
}
