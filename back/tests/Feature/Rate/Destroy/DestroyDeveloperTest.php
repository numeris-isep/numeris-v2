<?php

namespace Tests\Feature\Rate\Destroy;

use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingRate()
    {
        $rate_id = 1;
        $rate = Rate::find($rate_id);

        $this->assertDatabaseHas('rates', $rate->toArray());

        $this->json('DELETE', route('rates.destroy', ['rate_id' => $rate_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('rates', $rate->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownRate()
    {
        $rate_id = 0; // Unknown rate

        $this->json('DELETE', route('rates.destroy', ['rate_id' => $rate_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
