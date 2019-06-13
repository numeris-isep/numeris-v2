<?php

namespace Tests\Traits;

use App\Models\User;

trait UserProviderTrait
{
    public function userProvider()
    {
        $this->refreshApplication();

        return [[factory(User::class)->create()]];
    }
}
