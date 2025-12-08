<!DOCTYPE html>
<html>
<head>
    <title>New Task Assignment</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #e0bb35;">New Task Assigned</h2>
    <p>Hello {{ $task->assigned->name ?? 'User' }},</p>
    
    <p>You have been assigned to a new task in the project <strong>{{ $task->project->name ?? 'Project' }}</strong>.</p>
    
    <div style="background: #f4f4f4; padding: 15px; border-left: 4px solid #e0bb35; margin: 20px 0;">
        <p><strong>Task:</strong> {{ $task->name }}</p>
        <p><strong>Due Date:</strong> {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No Due Date' }}</p>
        <p><strong>Description:</strong><br> {{ $task->description ?? 'No description provided.' }}</p>
    </div>

    @if($calendarLink)
        <a href="{{ $calendarLink }}" 
            style="background-color: #4285F4; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
            Add to Google Calendar
        </a>
    @endif

    <p>Please log in to the dashboard to update your progress.</p>
    <p>Thank you.</p>
</body>
</html>