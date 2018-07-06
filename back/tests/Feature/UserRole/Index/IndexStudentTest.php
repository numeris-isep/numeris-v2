<?php

namespace Tests\Feature\UserRole\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group staff
     */
    public function testStaffAccessingRoleIndex()
    {
        $user_id = 1;

        $this->json('GET', route('users.roles.index', ['user_id' => $user_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);
    }
}
