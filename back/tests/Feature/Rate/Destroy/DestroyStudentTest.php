<?php

namespace Tests\Feature\Rate\Destroy;

use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentDeletingRate()
    {
        $rate_id = 1;
        $rate = Rate::find($rate_id);

        $this->assertDatabaseHas('rates', $rate->toArray());

        $this->json('DELETE', route('rates.destroy', ['rate_id' => $rate_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('rates', $rate->toArray());
    }
}
