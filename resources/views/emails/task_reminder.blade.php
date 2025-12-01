<!DOCTYPE html>
<html>
<head>
    <title>Task Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #d9534f;">Task Reminder</h2>
    <p>Hello {{ $task->assigned->name ?? 'User' }},</p>
    
    <p>This is a reminder for your task in the project <strong>{{ $task->project->name ?? 'Project' }}</strong>.</p>
    
    <div style="background: #fff3cd; padding: 15px; border-left: 4px solid #d9534f; margin: 20px 0;">
        <p><strong>Task:</strong> {{ $task->name }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No Due Date' }}</p>
        <p style="color: #d9534f; font-weight: bold;">
            @if($daysLeft === 0)
                DUE TODAY!
            @else
                {{ $daysLeft }} Days Left
            @endif
        </p>
    </div>

    <p>Please upload your progress immediately to avoid delays.</p>
</body>
</html>