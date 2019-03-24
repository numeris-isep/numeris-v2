<?php

namespace Tests\Feature\Mission\IndexAvailable;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAvailableStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingMissionIndex()
    {
        $this->json('GET', route('missions.index.available'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'isLocked',
                'title',
                'description',
                'startAt',
                'duration',
                'capacity',
                'address',
                'project' => [
                    'client',
                ],
                'applications'
            ]]);
    }
}
