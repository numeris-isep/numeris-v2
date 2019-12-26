<?php

namespace Tests\Feature\Application\Index;


use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = Role::STUDENT;

    /**
     * @group student
     */
    public function testStudentAccessingApplicationIndex()
    {
        $year = (string) now()->year;

        $this->json('POST', route('applications.index'), ['year' => $year])
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('errors.403')]]);
    }
}
