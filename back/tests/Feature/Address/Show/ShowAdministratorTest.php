<?php

namespace Tests\Feature\Address\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingUserShow()
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
