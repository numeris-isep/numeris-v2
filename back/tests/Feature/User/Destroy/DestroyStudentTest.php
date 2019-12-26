<?php

namespace Tests\Feature\User\Destroy;

use App\Models\Preference;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DestroyStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentDeletingUser()
    {
        $user = $this->activeUserProvider();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);

        $this->assertNull($user->deleted_at);
    }

    /**
     * @group student
     */
    public function testStudentDeletingHisOwnAccount()
    {
        $user = auth()->user();

        $this->assertNull($user->deleted_at);

        $this->json('DELETE', route('users.destroy', ['user_id' => $user->id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertNotNull(User::onlyTrashed()->find($user->id)->deleted_at);
    }
}
