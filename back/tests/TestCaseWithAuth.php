<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Schema;

abstract class TestCaseWithAuth extends TestCase
{
    protected $username;

    protected function setUp(): void
    {
        parent::setUp();

        if (! Schema::hasTable('users') || User::all()->isEmpty()) {
            $this->artisan('migrate:refresh', [
                '--seed'        => null,
                '--database'    => 'testing',
            ]);
        }

        $user = User::where('username', $this->username)->first();

        auth()->claims(['rol' => $user->role()->name])
            ->attempt([
                'email' => $user->email,
                'password' => 'azerty'
            ]);
    }
}
