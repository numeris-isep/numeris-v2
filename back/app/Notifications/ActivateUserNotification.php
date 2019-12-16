<?php

namespace App\Notifications;

use App\Mail\ActivateUserMail;

class ActivateUserNotification extends AbstractNotification
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new ActivateUserMail($notifiable))
            ->to($notifiable->email);
    }
}
