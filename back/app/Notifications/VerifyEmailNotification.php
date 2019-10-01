<?php

namespace App\Notifications;

use App\Mail\VerifyEmailMail;
use Illuminate\Auth\Notifications\VerifyEmail;

class VerifyEmailNotification extends VerifyEmail
{
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = env('FRONT_APP_URL') . '/email/verification?' . $this->formatParameters($notifiable);

        return (new VerifyEmailMail($notifiable, $url))
            ->to($notifiable->email);
    }

    public function formatParameters($notifiable): string
    {
        return explode('?', $this->verificationUrl($notifiable))[1];
    }
}
