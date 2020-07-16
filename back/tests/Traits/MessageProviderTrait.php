<?php

namespace Tests\Traits;

use App\Models\Application;
use App\Models\Bill;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Convention;
use App\Models\Invoice;
use App\Models\Mission;
use App\Models\Payslip;
use App\Models\Project;
use App\Models\Rate;
use App\Models\User;
use App\Models\Message;

trait MessageProviderTrait
{
    public function messageProvider(): Message
    {
        return factory(Message::class)->create();
    }

    public function messageActiveProvider(): Message
    {
        $message = factory(Message::class)->state('active')->create();
        return $message;
    }
}
