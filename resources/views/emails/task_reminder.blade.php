<!DOCTYPE html>
<html>
<head>
    <title>Task Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #d9534f;">Task Reminder</h2>
    <p>Hello {{ $task->assigned->name ?? 'User' }},</p>

    <p>You have <strong>{{ $tasks->count() }}</strong> pending tasks requiring your attention.</p>
    
    @foreach($tasks as $task)
        @php
            $dueDate = \Carbon\Carbon::parse($task->due_date);
            $isToday = $dueDate->isToday();
            $isOverdue = $dueDate->isPast() && !$isToday;
            $daysLeft = round($dueDate->floatDiffInDays(\Carbon\Carbon::now()));
        @endphp

        <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #d9534f; margin: 20px 0;">
            <p style="margin: 0 0 10px 0; font-size: 0.9em; color: #666;">
                Project: <strong>{{ $task->project->name ?? 'N/A' }}</strong>
            </p>
            
            <p style="margin: 5px 0;"><strong>Task:</strong> {{ $task->name }}</p>
            <p style="margin: 5px 0;"><strong>Due Date:</strong> {{ $task->due_date ? $dueDate->format('M d, Y') : 'No Due Date' }}</p>
            
            <p style="color: #d9534f; font-weight: bold; margin-top: 10px;">
                @if(!$task->due_date)
                    @elseif($isToday)
                    DUE TODAY!
                @elseif($isOverdue)
                    OVERDUE by {{ $daysLeft }} days
                @else
                    {{ $daysLeft }} Days Left
                @endif
            </p>
        </div>
    @endforeach

    <p>Please upload your progress immediately to avoid delays.</p>
</body>
</html>