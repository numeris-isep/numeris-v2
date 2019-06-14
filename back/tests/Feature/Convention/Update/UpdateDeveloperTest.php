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
     *
     * @dataProvider conventionProvider
     */
    public function testDeveloperUpdatingConventionAndCreatingRates($convention)
    {
        $conventionData = ['name' => 'Convention de test'];
        $newRate = [
            'id'            => null,
            'name'          => 'Nouvelles heures de test',
            'is_flat'       => false,
            'for_student'   => 12,
            'for_staff'     => 122,
            'for_client'    => 152,
        ];

        $data = array_merge($conventionData, ['rates' => [$newRate]]);
        unset($newRate['id']);

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $newRate);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]), $data)
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

        $this->assertDatabaseHas('conventions', $conventionData);
        $this->assertDatabaseHas('rates', $newRate);
    }

    /**
     * @group developer
     *
     * @dataProvider conventionProvider
     */
    public function testDeveloperUpdatingConventionAndUpdatingRates($convention)
    {
        $conventionData = ['name' => 'Convention de test'];
        $rate1 = [
            'id'            => $convention->rates->get(0)->id,
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 11,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];
        $rate2 = [
            'id'            => $convention->rates->get(1)->id,
            'name'          => 'Forfait de test',
            'is_flat'       => true,
            'hours'         => 11,
            'for_student'   => 101,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $data = array_merge($conventionData, ['rates' => [$rate1, $rate2]]);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]), $data)
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

        $this->assertDatabaseHas('conventions', $conventionData);
        $this->assertDatabaseHas('rates', $rate1);
        $this->assertDatabaseHas('rates', $rate2);
    }

    /**
     * @group developer
     *
     * @dataProvider conventionProvider
     */
    public function testDeveloperUpdatingConventionAndDeletingRate($convention)
    {
        $conventionData = ['name' => 'Convention de test'];
        $rate1 = [
            'id'            => $convention->rates->get(0)->id,
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 11,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];

        $data = array_merge($conventionData, ['rates' => [$rate1]]);
        unset($rate1['id']);

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseHas('rates', $convention->rates->get(1)->toArray());

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]), $data)
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

        $this->assertDatabaseHas('conventions', $conventionData);
        $this->assertDatabaseHas('rates', $rate1);
        $this->assertDatabaseMissing('rates', $convention->rates->get(1)->toArray());
    }

    /**
     * @group developer
     *
     * @dataProvider clientAndProjectAndMissionAndConventionWithBillsProvider
     */
    public function testDeveloperUpdatingConventionWithRatesWithBillsAndUpdatingRates($client, $project, $mission, $convention)
    {
        $conventionData = ['name' => 'Convention de test'];
        $rate1 = [
            'id'            => $convention->rates->get(0)->id,
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 11,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];
        $rate2 = [
            'id'            => $convention->rates->get(1)->id,
            'name'          => 'Forfait de test',
            'is_flat'       => true,
            'hours'         => 11,
            'for_student'   => 101,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];

        $data = array_merge($conventionData, ['rates' => [$rate1, $rate2]]);
        unset($rate1['id']);
        unset($rate2['id']);

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]), $data)
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

        $this->assertDatabaseHas('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);
    }

    /**
     * @group developer
     *
     * @dataProvider clientAndProjectAndMissionAndConventionWithBillsProvider
     */
    public function testDeveloperUpdatingConventionWithRatesWithBillsAndDeletingRate($client, $project, $mission, $convention)
    {
        $conventionData = ['name' => 'Convention de test'];
        $rate1 = [
            'id'            => $convention->rates->get(0)->id,
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 11,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];

        $data = array_merge($conventionData, ['rates' => [$rate1]]);
        unset($rate1['id']);

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseHas('rates', $convention->rates->get(1)->toArray());

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]), $data)
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

        $this->assertDatabaseHas('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseHas('rates', $convention->rates->get(1)->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperUpdatingUnknownConvention()
    {
        $convention_id = 0; // Unknown convention

        $conventionData = ['name' => 'Convention de test'];
        $rate1 = [
            'id'            => null,
            'name'          => 'Heures de test',
            'is_flat'       => false,
            'for_student'   => 11,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];
        $rate2 = [
            'id'            => null,
            'name'          => 'Forfait de test',
            'is_flat'       => true,
            'hours'         => 11,
            'for_student'   => 101,
            'for_staff'     => 121,
            'for_client'    => 151,
        ];

        $data = array_merge($conventionData, ['rates' => [$rate1, $rate2]]);

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention_id]), $data)
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);

        $this->assertDatabaseMissing('conventions', $conventionData);
        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);
    }

    /**
     * @group developer
     *
     * @dataProvider conventionProvider
     */
    public function testDeveloperUpdatingConventionWithoutData($convention)
    {
        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]))
            ->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors(['name']);
    }
}
