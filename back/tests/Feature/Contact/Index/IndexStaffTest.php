<?php

namespace Tests\Feature\Contact\Index;

use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexStaffTest extends TestCaseWithAuth
{
    protected $username = Role::STAFF;

    /**
     * @group staff
     */
    public function testStaffAccessingContactConventionIndex()
    {
        $this->json('GET', route('contacts.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'id',
                'firstName',
                'lastName',
                'email',
                'phone',
            ]]);

    }
}
