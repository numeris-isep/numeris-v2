<?php

namespace Tests\Feature\Auth\Subscribe;

use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class SubscribeTest extends TestCase
{
    /**
     * @group any
     */
    public function testUserSubscription()
    {
        $user_data = $db_data = [
            'email'                     => 'test@isep.fr',
            'first_name'                => 'Test',
            'last_name'                 => 'Numeris',
            'promotion'                 => now()->addYear()->year,
            'birth_date'                => '2001-06-13 09:50:16',
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azerty';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('POST', route('subscribe'), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'preferenceId',
                'addressId',
                'activated',
                'touAccepted',
                'subscriptionPaidAt',
                'email',
                'firstName',
                'lastName',
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
     * @group any
     */
    public function testUserSubscriptionWithAleadyUsedData()
    {
        $user_data = $db_data = [
            'email'         => 'developer@isep.fr',
            'first_name'    => 'Test',
            'last_name'     => 'Numeris',
            'promotion'     => '1990',
            'birth_date'    => '2001-06-13 09:50:16',
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azerty';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('POST', route('subscribe'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group any
     */
    public function testUserSubscriptionWithOtherDomainEmail()
    {
        $user_data = $db_data = [
            'email'         => 'developer@other-domain.fr',
            'first_name'    => 'Test',
            'last_name'     => 'Numeris',
            'promotion'     => '1991',
            'birth_date'    => '2001-06-13 09:50:16',
        ];
        $address_data = [
            'street'    => '1 rue Quelquepart',
            'zip_code'  => '75015',
            'city'      => 'Paris'
        ];

        // Add 'password' datas after init to avoid the check on unknown column
        // 'password_confirmation' and on uncrypted 'password'
        $user_data['password'] = $user_data['password_confirmation'] = 'azerty';

        $data = array_merge($user_data, ['address' => $address_data]);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);

        $this->json('POST', route('subscribe'), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['email']);

        $this->assertDatabaseMissing('users', $db_data);
        $this->assertDatabaseMissing('addresses', $address_data);
    }

    /**
     * @group any
     */
    public function testUserSubscriptionWithoutData()
    {
        $this->json('POST', route('subscribe'))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'password', 'first_name', 'last_name',
                'email', 'birth_date', 'address.street',
                'address.zip_code', 'address.city',
            ]);
    }
}
