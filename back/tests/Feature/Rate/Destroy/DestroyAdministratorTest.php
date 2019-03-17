<?php

namespace Tests\Feature\Rate\Destroy;

use App\Models\Rate;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingRate()
    {
        $rate_id = 1;
        $rate = Rate::find($rate_id);

        $this->assertDatabaseHas('rates', $rate->toArray());

        $this->json('DELETE', route('rates.destroy', ['rate_id' => $rate_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('rates', $rate->toArray());
    }
}
