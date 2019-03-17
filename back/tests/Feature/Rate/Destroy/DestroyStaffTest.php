<?php

namespace Tests\Feature\Rate\Destroy;

use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingRate()
    {
        $rate_id = 1;
        $rate = Rate::find($rate_id);

        $this->assertDatabaseHas('rates', $rate->toArray());

        $this->json('DELETE', route('rates.destroy', ['rate_id' => $rate_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('rates', $rate->toArray());
    }
}
