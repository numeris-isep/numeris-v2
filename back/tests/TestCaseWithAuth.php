<?php

namespace Tests;

use App\Models\User;

abstract class TestCaseWithAuth extends TestCase
{
    protected $username;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::where('username', $this->username)->first();

        auth()->claims(['rol' => $user->role()->name])
            ->attempt([
                'email' => $user->email,
                'password' => 'azerty'
            ]);
    }
}