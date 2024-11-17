<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;

    public $technician;
    public $taskmaster;
    public $maintenance;
    public $detail;

    public function __construct($technician, $taskmaster, $maintenance, $detail)
    {
        $this->technician = $technician;
        $this->taskmaster = $taskmaster;
        $this->maintenance = $maintenance;
        $this->detail = $detail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Send Report Notification',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reporter',
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
