<?php

namespace Tests\Feature\Convention\Update;
use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperUpdatingConvention()
    {
        $convention_id = 1;

        $data = [
            'name' => '11-1111',
        ];

        $this->assertDatabaseMissing('conventions', $data);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_CREATED)
            ->assertJsonStructure([
                'id',
                'name',
            ]);

        $this->assertDatabaseHas('conventions', $data);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingConventionWithAlreadyUsedData()
    {
        $convention_id = 1;

        $data = [
            'name' => Convention::find(1)->name, // Already used
        ];

        $this->assertDatabaseHas('conventions', $data);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownConvention()
    {
        $convention_id = 0; // Unknown convention

        $data = [
            'name' => '11-1111',
        ];

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingConventionWithoutData()
    {
        $convention_id = 1;

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }
}
