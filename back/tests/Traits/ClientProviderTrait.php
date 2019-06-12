<?php

namespace Tests\Traits;

use App\Models\Client;

trait ClientProviderTrait
{
    public function clientProvider()
    {
        $this->refreshApplication();

        return [[factory(Client::class)->create()]];
    }
}
