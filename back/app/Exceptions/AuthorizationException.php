<?php

namespace App\Exceptions;

class AuthorizationException extends \Exception
{
    protected $message;

    public function __construct(string $message)
    {
        $this->message = $message ?? trans('api.403');
    }
}