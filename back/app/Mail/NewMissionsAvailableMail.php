<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;

class NewMissionsAvailableMail extends Mailable
{
    protected $missions;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Collection $missions)
    {
        $this->missions = $missions;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Nouvelles missions disponibles')
            ->markdown('mails.missions-available', ['missions' => $this->missions]);
    }
}
