<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Carbon\Carbon;

class TaskReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $tasks;

    public function __construct($tasks) {
        $this->tasks = $tasks;
    }

    public function build()
    {
        $hasUrgentTask = $this->tasks->contains(function ($task) {
            $due = Carbon::parse($task->due_date)->startOfDay();
            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            return (int) $today->diffInDays($due, false) === 0;
        });

        $subject = $hasUrgentTask 
            ? 'URGENT: Tasks Due Today - Action Required' 
            : 'Reminder: You have ' . $this->tasks->count() . ' pending tasks';

        return $this->subject($subject)
                    ->view('emails.task_reminder')
                    ->with([
                        'tasks' => $this->tasks,
                        'task'  => $this->tasks->first() 
                    ]);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@thewkm.com', 'WKM Task System'),
            subject: 'Task Reminder Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.task_reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}