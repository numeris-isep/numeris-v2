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
        if (! in_array($application->status, [Application::ACCEPTED, Application::REFUSED])) {
            return;
        }

        $user = $application->user;
        $attribute = Preference::statusToAttribute()[$application->status];

        if ($user->preference->$attribute) {
            $this->queueMail($user->email, new ApplicationMail($application));
        }
    }

    private function queueMail($emails, Mailable $mailable)
    {
        Mail::to($emails)->queue($mailable);
    }
}