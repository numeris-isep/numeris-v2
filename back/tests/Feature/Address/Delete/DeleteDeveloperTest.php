<?php

namespace Tests\Feature\Address\Delete;

use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class DeleteDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperDeletingAddress()
    {
        $address_id = 1;
        $address = Address::find($address_id);
        $user = $address->user;

        $this->assertDatabaseHas('addresses', $address->toArray());
        $this->assertDatabaseHas('users', $user->toArray());

        $this->json('DELETE', route('addresses.destroy', ['address_id' => $address_id]))
            ->assertStatus(JsonResponse::HTTP_NO_CONTENT);

        $this->assertDatabaseMissing('addresses', $address->toArray());
        $this->assertDatabaseHas('users', [
            'id'            => $user->id,
            'address_id'    => null, // <-- onDelete('set null')
        ]);
    }

    /**
     * @group developer
     */
    public function testDeveloperDeletingAddressWithUnknownAddress()
    {
        $address_id = 0; // Unknown address

        $this->json('DELETE', route('addresses.destroy', ['address_id' => $address_id]))
            ->assertStatus(JsonResponse::HTTP_NOT_FOUND)
            ->assertJson([
                'error' => trans('api.404')
            ]);
    }
}
