<?php

namespace Tests\Feature\ClientConvention\Store;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = Role::DEVELOPER;

    /**
     * @group developer
     */
    public function testDeveloperCreatingConvention()
    {
        $client = $this->clientProvider();

        $rate1 = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];
        $rate2 = [
            'name'          => 'Forfait de test',
            'is_flat'       => true,
            'hours'         => 10,
            'for_student'   => 100,
            'for_staff'     => 120,
            'for_client'    => 150,
        ];

        $data = ['rates' => [$rate1, $rate2]];

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client->id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'createdAt',
                'updatedAt',
                'rates' => [[
                    'id',
                    'name',
                    'isFlat',
                    'forStudent',
                    'forStaff',
                    'forClient',
                ]],
            ]);

        $this->assertDatabaseHas('rates', $rate1);
        $this->assertDatabaseHas('rates', $rate2);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithUnknownClient()
    {
        $client_id = 0; // Unknown client

        $rate1 = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];
        $rate2 = [
            'name'          => 'Forfait de test',
            'is_flat'       => true,
            'hours'         => 10,
            'for_student'   => 100,
            'for_staff'     => 120,
            'for_client'    => 150,
        ];

        $data = ['rates' => [$rate1, $rate2]];

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('errors.404')]]);

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithoutData()
    {
        $client = $this->clientProvider();

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['rates']);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithMissingFields()
    {
        $client = $this->clientProvider();

        $rate1 = [];
        $rate2 = [];

        $data = ['rates' => [$rate1, $rate2]];

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'rates.0.name', 'rates.0.for_student', 'rates.0.for_staff', 'rates.0.for_client', 'rates.0.is_flat',
                'rates.1.name', 'rates.1.for_student', 'rates.1.for_staff', 'rates.1.for_client', 'rates.1.is_flat',
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithWrongValues()
    {
        $client = $this->clientProvider();

        $rate1 = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => -10,
            'for_staff'     => -12,
            'for_client'    => -15,
        ];
        $rate2 = [
            'name'          => 'Forfait de test',
            'is_flat'       => true,
            'hours'         => -10,
            'for_student'   => -100,
            'for_staff'     => -120,
            'for_client'    => -150,
        ];

        $data = ['rates' => [$rate1, $rate2]];

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'rates.0.for_student', 'rates.0.for_staff', 'rates.0.for_client',
                'rates.1.hours', 'rates.1.for_student', 'rates.1.for_staff', 'rates.1.for_client',
            ]);

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingConventionWithFlatRatesWithoutHours()
    {
        $client = $this->clientProvider();

        $rate1 = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];
        $rate2 = [
            'name'          => 'Forfait de test',
            'is_flat'       => true, // No hours
            'for_student'   => 100,
            'for_staff'     => 120,
            'for_client'    => 150,
        ];

        $data = ['rates' => [$rate1, $rate2]];

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $this->json('POST', route('clients.conventions.store', ['client_id' => $client->id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['rates.1.hours']);

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);
    }
}
