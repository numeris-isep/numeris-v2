<?php

namespace Tests\Feature\Auth\ForgotPassword;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    /**
     * @group any
     */
    public function testForgotPassword()
    {
        $user = $this->activeUserProvider();

        $this->json('POST', route('password.forgot'), ['email' => $user->email])
            ->assertStatus(JsonResponse::HTTP_OK)
            ->assertJson(['message' => [trans('passwords.sent')]]);

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }
}