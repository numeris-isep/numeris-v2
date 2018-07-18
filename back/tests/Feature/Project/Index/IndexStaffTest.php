<?php

namespace Tests\Feature\Project\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccesingProjectIndex()
    {
        $this->json('GET', route('projects.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'name',
                'step',
                'start_at',
                'is_private',
                'money_received_at',
                'created_at',
                'updated_at',
                'client',
                'convention',
            ]]);
    }
}
