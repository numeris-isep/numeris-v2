<?php

namespace Tests\Feature\Convention\Destroy;

use App\Models\Convention;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentDeletingUser()
    {
        $convention_id = 1;
        $convention = Convention::find($convention_id);

        $this->assertDatabaseHas('conventions', $convention->toArray());

        $this->json('DELETE', route('conventions.destroy', ['convention_id' => $convention_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('conventions', $convention->toArray());
    }
}
