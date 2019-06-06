<?php

namespace Tests\Traits;

use App\Models\Contact;

trait ClientProviderTrait
{
    public function clientContactProvider()
    {
        $this->refreshApplication();

        return [[factory(Contact::class)->create()]];
    }
}
