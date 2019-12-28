<?php

namespace App\Policies;

use App\Exceptions\AuthorizationException;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class AbstractPolicy
{
    use HandlesAuthorization;

    protected function deny(string $message)
    {
        throw new AuthorizationException($message);
    }
}