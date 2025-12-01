<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TaskReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public $task, public $daysLeft) {}

    public function build()
    {
        $subject = $this->daysLeft === 0 
            ? 'URGENT: Task Due Today - ' . $this->task->name 
            : 'Reminder: Task Due in ' . $this->daysLeft . ' days - ' . $this->task->name;

        return $this->subject($subject)->view('emails.task_reminder');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Task Reminder Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.task_reminder',
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
