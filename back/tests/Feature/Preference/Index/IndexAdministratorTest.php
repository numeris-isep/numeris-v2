<?php

namespace Tests\Feature\Preference\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexAdministratorTest extends TestCaseWithAuth
{
    protected $username = 'administrator';

    /**
     * @group administrator
     */
    public function testAdministratorAccessingPreferenceIndex()
    {
        $this->json('GET', route('preferences.index'))
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJsonStructure([[
                'on_new_mission',
                'on_acceptance',
                'on_refusal',
            ]]);
    }
}
