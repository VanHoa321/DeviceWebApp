<?php

namespace App\Mail;

use App\Models\MaintenanceDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MaintenanceCompleted extends Mailable
{
    use Queueable, SerializesModels;

    public $reporter;
    public $user;
    public $detail;

    public function __construct($reporter, $user, $detail)
    {
        $this->reporter = $reporter;
        $this->user = $user;
        $this->detail = $detail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Công việc bảo trì hoàn thành'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.maintenance_completed',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
