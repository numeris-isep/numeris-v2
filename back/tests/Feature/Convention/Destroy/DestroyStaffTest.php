<?php

namespace Tests\Feature\Convention\Destroy;

use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffDeletingConvention()
    {
        $convention_id = 1;
        $convention = Convention::find($convention_id);

        $this->assertDatabaseHas('conventions', $convention->toArray());

        $this->json('DELETE', route('conventions.destroy', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('conventions', $convention->toArray());
    }
}
