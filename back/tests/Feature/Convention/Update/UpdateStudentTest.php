<?php

namespace Tests\Feature\Convention\Update;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class UpdateUpdateStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentUpdatingConvention()
    {
        $convention = $this->conventionProvider();

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

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);

        $data = ['rates' => [$rate1, $rate2]];

        $this->json('PUT', route('conventions.update', ['convention_id' => $convention->id]), $data)
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertDatabaseMissing('rates', $rate1);
        $this->assertDatabaseMissing('rates', $rate2);
    }
}
