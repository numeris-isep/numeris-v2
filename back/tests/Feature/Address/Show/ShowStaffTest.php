<?php

namespace Tests\Feature\Address\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingUserShow()
    {
        $address_id = 1;

        $this->json('GET', route('addresses.show', ['address_id' => $address_id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'street',
                'zip_code',
                'city',
            ]);
    }
}
