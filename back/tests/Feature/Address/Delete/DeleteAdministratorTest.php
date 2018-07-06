<?php

namespace Tests\Feature\Address\Delete;

use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorDeletingAddress()
    {
        $address_id = 1;
        $address = Address::find($address_id);
        $user = $address->user;

        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', route('addresses.destroy', ['address_id' => $address_id]))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson([
                'error' => trans('api.403')
            ]);

        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('users', $user->toArray());
    }
}
