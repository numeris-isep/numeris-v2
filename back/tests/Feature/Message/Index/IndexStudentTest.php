<?php

namespace Tests\Feature\Message\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group message
     */
    public function testStudentMessageIndex()
    {
        $this->json('GET', route('messages.index'))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
