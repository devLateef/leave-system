<?php

namespace App\Mail;

use App\Models\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicationReviewed extends Mailable
{
    use Queueable, SerializesModels;
    protected $leave;
    protected $recipients;

    /**
     * Create a new message instance.
     * @param LeaveApplication $leaveApplication
     * @param string|array $recipients
     */
    public function __construct(Leave $leave, $recipients)
    {
        $this->leave = $leave;
        $this->recipients = is_array($recipients) ? $recipients : [$recipients];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            to: $this->recipients,
            subject: 'Your Application Has Been Reviewed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.application-reviewed',
            with: ['leave' => $this->leave],
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
