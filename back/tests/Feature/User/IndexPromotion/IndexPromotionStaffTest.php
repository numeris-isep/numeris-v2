<?php

namespace Tests\Feature\User\IndexPromotion;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexPromotionStaffTest extends TestCaseWithAuth
{
    protected $username = 'staff';

    /**
     * @group staff
     */
    public function testStaffAccessingUserIndexPromotion()
    {
        $this->json('GET', route('users.index'))
            ->assertStatus(JsonResponse::HTTP_OK);
    }
}
