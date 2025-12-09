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
    protected $description = 'Send batched reminders for tasks due in 7, 3, 1, or 0 days';

    public function handle()
    {
        $this->info('Starting Reminder Check...');
        
        $allTasks = ManagementProjectTask::with(['assigned', 'project', 'progressLogs'])
            ->where('status_id', '!=', 3)
            ->whereNotNull('due_date')
            ->whereNotNull('assigned_to')
            ->get();

        $this->info('Found ' . $allTasks->count() . ' total active tasks. Filtering and Grouping...');

        $reminders = [];

        foreach ($allTasks as $task) {
            if (method_exists($task, 'progressLogs') && $task->progressLogs()->count() > 0) {
                continue; 
            }

            try {
                $due = Carbon::parse($task->due_date)->startOfDay();
                $today = Carbon::now('Asia/Jakarta')->startOfDay();
                
                $diffInDays = (int) $today->diffInDays($due, false);

                if (in_array($diffInDays, [7, 3, 1, 0])) {
                    $userId = $task->assigned_to;
                    $user = $task->assigned;

                    if ($user && $user->email) {
                        if (!isset($reminders[$userId])) {
                            $reminders[$userId] = [
                                'user' => $user,
                                'tasks' => collect([])
                            ];
                        }
                        
                        $reminders[$userId]['tasks']->push($task);
                        
                        $this->info(" -> Queued Task: {$task->name} (Due: $diffInDays days) for {$user->email}");
                    } else {
                        $this->error(" -> Skipped Task {$task->id}: User has no email.");
                    }
                }
            } catch (\Exception $e) {
                $this->error(" -> Error processing task {$task->id}: " . $e->getMessage());
            }
        }

        $this->info('Sending Emails...');

        foreach ($reminders as $userId => $data) {
            $user = $data['user'];
            $userTasks = $data['tasks'];

            try {
                Mail::to($user->email)->send(new TaskReminderMail($userTasks));
                $this->info(" -> EMAIL SENT to {$user->email} containing " . $userTasks->count() . " tasks.");
            } catch (\Exception $e) {
                $this->error(" -> Failed to send email to {$user->email}: " . $e->getMessage());
            }
        }
        
        $this->info('Reminder Check Complete.');
    }
}