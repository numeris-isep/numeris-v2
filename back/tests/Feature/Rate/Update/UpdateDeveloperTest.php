<?php

namespace Tests\Feature\Rate\Update;
use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingRate()
    {
        $rate_id = 1;

        $data = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('PUT', route('rates.update', ['rate_id' => $rate_id]), $data)
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
    public function testDeveloperUpdatingFlatRate()
    {
        $rate_id = 1;

        $data = [
            'name'          => 'Forfait 7h de test',
            'is_flat'       => true,
            'hours'         => 7,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('PUT', route('rates.update', ['rate_id' => $rate_id]), $data)
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
    public function testDeveloperUpdatingFlatRateWithoutHours()
    {
        $rate_id = 1;

        $data = [
            'name'          => 'Forfait 7h de test',
            'is_flat'       => true,
            // No hours
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->assertDatabaseMissing('rates', $data);

        $this->json('PUT', route('rates.update', ['rate_id' => $rate_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['hours']);

        $this->assertDatabaseMissing('rates', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownRate()
    {
        $rate_id = 0; // Unknown rate

        $data = [
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 10,
            'for_staff'     => 12,
            'for_client'    => 15,
        ];

        $this->json('PUT', route('rates.update', ['rate_id' => $rate_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingRateWithoutData()
    {
        $rate_id = 1;

        $this->json('PUT', route('rates.update', ['rate_id' => $rate_id]))
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
