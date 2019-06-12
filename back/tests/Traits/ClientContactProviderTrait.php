<?php

namespace Tests\Traits;

use App\Models\Contact;

trait ClientContactProviderTrait
{
    public function clientContactProvider()
    {
        $this->refreshApplication();

        return [[factory(Contact::class)->create()]];
    }
}
