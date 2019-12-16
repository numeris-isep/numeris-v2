<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ActivateUserMail extends Mailable
{
    use Queueable, SerializesModels;

    private $notifiable;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable)
    {
        $this->notifiable = $notifiable;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Ton compte a été ' . ($this->notifiable->activated ? 'activé' : 'désactivé'))
            ->markdown('mails.activate-user', ['notifiable' => $this->notifiable]);
    }
}
