<?php

namespace Tests\Feature\UserRole\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group staff
     */
    public function testStaffAccessingRoleIndex()
    {
        $user = $this->activeStudentProvider();

        $this->json('GET', route('users.roles.index', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
