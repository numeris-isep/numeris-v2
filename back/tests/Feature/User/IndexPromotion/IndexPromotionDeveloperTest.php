<?php

namespace Tests\Feature\User\IndexPromotion;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexPromotionDeveloperTest extends TestCaseWithAuth
{
    protected $username = 'developer';

    /**
     * @group developer
     */
    public function testDeveloperAccessingUserIndexPromotion()
    {
        $this->json('GET', route('users.index'))
            ->assertStatus(JsonResponse::HTTP_OK);
    }
}
