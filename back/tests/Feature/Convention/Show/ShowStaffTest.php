<?php

namespace Tests\Feature\Convention\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     *
     * @dataProvider conventionProvider
     */
    public function testStaffAccessingConventionShow($convention)
    {
        $this->json('GET', route('conventions.show', ['convention_id' => $convention->id]))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([
                'id',
                'name',
                'createdAt',
                'updatedAt',
                'rates' => [[
                    'id',
                    'name',
                    'isFlat',
                    'forStudent',
                    'forStaff',
                    'forClient',
                ]]
            ]);
    }
}
