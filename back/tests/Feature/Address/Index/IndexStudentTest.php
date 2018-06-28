<?php

namespace Tests\Feature\Address\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingAddressIndex()
    {
        $this->json('GET', route('addresses.index'))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => 'Forbidden'
            ]);
    }
}
