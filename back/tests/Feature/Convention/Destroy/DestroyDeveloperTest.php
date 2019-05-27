<?php

namespace Tests\Feature\Convention\Destroy;

use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingConvention()
    {
        $convention_id = 1;
        $convention = Convention::find($convention_id);

        $this->assertDatabaseHas('conventions', $convention->toArray());

        $this->json('DELETE', route('conventions.destroy', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('conventions', $convention->toArray());
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingUnknownConvention()
    {
        $convention_id = 0; // Unknown convention

        $this->json('DELETE', route('conventions.destroy', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson(['errors' => [trans('api.404')]]);
    }
}
