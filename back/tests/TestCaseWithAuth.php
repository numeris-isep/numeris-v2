<?php

namespace Tests;

use App\Models\User;

abstract class TestCaseWithAuth extends TestCase
{
    protected $username;

    protected function setUp()
    {
        parent::setUp();

        $user = User::where('username', $this->username)->first();

        auth()->claims(['rol' => $user->currentRole()->name])
            ->attempt([
                'email' => $user->email,
                'password' => 'azerty'
            ]);
    }
}