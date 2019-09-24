<?php

namespace App\Mail;

use App\Models\Application;
use App\Models\Preference;
use Illuminate\Contracts\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function missionApplication(Application $application): void
    {
        $user = $application->user;
        $attribute = Preference::statusToAttribute()[$application->status];

        if ($user->preference->$attribute) {
            $this->sendMail('eliottdes@gmail.com', new ApplicationMail($application));
        }
    }

    private function sendMail($emails, Mailable $mailable)
    {
        Mail::to($emails)->send($mailable);
    }
}