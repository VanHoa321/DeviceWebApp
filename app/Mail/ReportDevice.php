<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportDevice extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $maintenance;
    public $detail;

    public function __construct($user, $maintenance, $detail)
    {
        $this->user = $user;
        $this->maintenance = $maintenance;
        $this->detail = $detail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Report Device',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.report',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
