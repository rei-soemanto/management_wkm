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
        $this->info('Starting Reminder Check...');
        
        $tasks = ManagementProjectTask::where('status_id', '!=', 3)
            ->whereNotNull('due_date')
            ->whereNotNull('assigned_to')
            ->get();

        $this->info('Found ' . $tasks->count() . ' active tasks.');

        foreach ($tasks as $task) {
            $this->info("Checking Task: {$task->name} (ID: {$task->id})");

            if (method_exists($task, 'progressLogs') && $task->progressLogs()->count() > 0) {
                $this->info(" -> Skipped: Progress already uploaded.");
                continue;
            }

            try {
                $due = Carbon::parse($task->due_date)->startOfDay();
                $today = Carbon::now('Asia/Jakarta')->startOfDay();
                
                $diffInDays = $today->diffInDays($due, false);
                $diffInDays = (int) $diffInDays;

                $this->info(" -> Due: {$due->format('Y-m-d')} | Today: {$today->format('Y-m-d')} | Diff: $diffInDays days");

                if (in_array($diffInDays, [7, 3, 1, 0])) {
                    $user = $task->assigned;
                    if ($user && $user->email) {
                        Mail::to($user->email)->send(new TaskReminderMail($task, $diffInDays));
                        $this->info(" -> EMAIL SENT to {$user->email}");
                    } else {
                        $this->error(" -> User has no email!");
                    }
                } else {
                    $this->info(" -> Skipped: Day gap ($diffInDays) is not 0, 1, 3, or 7.");
                }
            } catch (\Exception $e) {
                $this->error(" -> Error processing dates: " . $e->getMessage());
            }
        }
        
        $this->info('Reminder Check Complete.');
    }
}