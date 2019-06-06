<?php

namespace Tests;

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Tests\Traits\ApplicationProviderTrait;

abstract class TestCaseWithAuth extends TestCase
{
    use ApplicationProviderTrait;

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
