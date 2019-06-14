<?php

namespace Tests\Feature\User\IndexPromotion;

use Illuminate\Http\JsonResponse;
use Tests\TestCaseWithAuth;

class IndexPromotionStudentTest extends TestCaseWithAuth
{
    protected $username = 'student';

    /**
     * @group student
     */
    public function testStudentAccessingUserIndexPromotion()
    {
        $this->json('GET', route('users.index.promotion'))
            ->assertStatus(JsonResponse::HTTP_FORBIDDEN)
            ->assertJson(['errors' => [trans('api.403')]]);
    }
}
