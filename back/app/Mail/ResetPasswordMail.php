<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    private $notifiable;

    private $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($notifiable, $token)
    {
        $this->notifiable = $notifiable;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Réinitialisation du mot de passe de votre compte Numéris')
            ->markdown('mails.reset-password', ['notifiable' => $this->notifiable, 'token' => $this->token]);
    }
}
