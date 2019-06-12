<?php

namespace Tests\Feature\Convention\Show;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class ShowAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     *
     * @dataProvider conventionProvider
     */
    public function testAdministratorAccessingConventionShow($convention)
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
