<?php

namespace Tests\Feature\Address\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingUserIndex()
    {
        $this->json('GET', route('addresses.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'street',
                'zip_code',
                'city',
            ]]);
    }
}
