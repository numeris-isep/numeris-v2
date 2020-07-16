<?php

namespace Tests\Feature\Message\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group message
     */
    public function testStaffMessageIndex()
    {
        $this->json('GET', route('messages.index'))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
