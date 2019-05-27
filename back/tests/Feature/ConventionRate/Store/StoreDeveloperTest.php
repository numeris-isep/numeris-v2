<?php

namespace Tests\Feature\ConventionRate\Store;
use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class StoreDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperCreatingRate()
    {
        $convention_id = 1;

        $data = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('POST', route('conventions.rates.store', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'isFlat',
                'forStudent',
                'forStaff',
                'forClient',
            ]);

        $this->assertDatabaseHas('rates', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingFlatRate()
    {
        $convention_id = 1;

        $data = [
            'name'          => 'Forfait 7h de test',
            'is_flat'       => true,
            'hours'         => 7,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('POST', route('conventions.rates.store', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
                'isFlat',
                'hours',
                'forStudent',
                'forStaff',
                'forClient',
            ]);

        $this->assertDatabaseHas('rates', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingFlatRateWithoutHours()
    {
        $convention_id = 1;

        $data = [
            'name'          => 'Forfait 7h de test',
            'is_flat'       => true,
            // No hours
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('POST', route('conventions.rates.store', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['hours']);

        $this->assertDatabaseMissing('rates', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingRateWithUnknownConvention()
    {
        $convention_id = 0; // Unknown convention

        $data = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->json('POST', route('conventions.rates.store', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }

    /**
     * @group developer
     */
    public function testDeveloperCreatingRateWithoutData()
    {
        $convention_id = 1;

        $this->json('POST', route('conventions.rates.store', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors([
                'name',
                'is_flat',
                'for_student',
                'for_staff',
                'for_client',
            ]);
    }
}
