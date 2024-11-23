<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AduanNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $aduan;

    /**
     * Create a new message instance.
     */
    public function __construct($aduan)
    {
        $this->aduan = $aduan;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Notifikasi Aduan Baru')
                    ->view('emails.aduan_notification')
                    ->with('aduan', $this->aduan);
    }
}
