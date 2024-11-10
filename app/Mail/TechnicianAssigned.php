<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TechnicianAssigned extends Mailable
{
    use Queueable, SerializesModels;

    public $reporter;
    public $taskmaster;
    public $maintenance;
    public $detail;

    public function __construct($reporter, $taskmaster, $maintenance, $detail)
    {
        $this->reporter = $reporter;
        $this->taskmaster = $taskmaster;
        $this->maintenance = $maintenance;
        $this->detail = $detail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Technician Assigned',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.assigned',
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
