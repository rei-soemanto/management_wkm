<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Managements\ManagementProjectTask;
use App\Mail\TaskReminderMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Send reminders for H-7, H-3, H-1, and H-0';

    public function handle()
    {
        $tasks = ManagementProjectTask::where('status_id', '!=', 3)
            ->whereNotNull('due_date')
            ->whereNotNull('assigned_to')
            ->get();

        foreach ($tasks as $task) {
            if ($task->progressLogs()->count() > 0) {
                continue;
            }

            $dueDate = Carbon::parse($task->due_date);
            $today = Carbon::now('Asia/Jakarta')->startOfDay();
            $diffInDays = $today->diffInDays($dueDate, false);

            if (in_array($diffInDays, [7, 3, 1, 0])) {
                $user = $task->assigned;
                if ($user && $user->email) {
                    Mail::to($user->email)->send(new TaskReminderMail($task, $diffInDays));
                    $this->info("Reminder sent to {$user->email} for task {$task->name} (H-{$diffInDays})");
                }
            }
        }
    }
}