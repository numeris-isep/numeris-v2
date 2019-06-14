<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Traits\ApplicationProviderTrait;
use Tests\Traits\ClientProviderTrait;
use Tests\Traits\ConventionProviderTrait;
use Tests\Traits\MissionProviderTrait;
use Tests\Traits\ProjectProviderTrait;
use Tests\Traits\UserProviderTrait;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        WithoutMiddleware,
        DatabaseTransactions,
        ProjectProviderTrait,
        ClientProviderTrait,
        ApplicationProviderTrait,
        ConventionProviderTrait,
        MissionProviderTrait,
        UserProviderTrait;
}
