<?php

namespace Tests\Feature\Preference\Index;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingPreferenceIndex()
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
