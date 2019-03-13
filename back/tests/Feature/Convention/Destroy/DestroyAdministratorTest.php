<?php

namespace Tests\Feature\Convention\Destroy;

use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingConvention()
    {
        $convention_id = 1;
        $convention = Convention::find($convention_id);

        $this->assertDatabaseHas('conventions', $convention->toArray());

        $this->json('DELETE', route('conventions.destroy', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('conventions', $convention->toArray());
    }
}
