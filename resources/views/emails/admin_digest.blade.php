<!DOCTYPE html>
<html>
<head>
    <title>Daily Progress Recap</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #e0bb35;">Daily Progress Recap</h2>
    <p>Here is the list of progress reports uploaded today ({{ now()->format('M d, Y') }}):</p>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
        <thead>
            <tr style="background: #e0bb35; color: black;">
                <th style="padding: 10px; border: 1px solid #ddd;">Project</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Task</th>
                <th style="padding: 10px; border: 1px solid #ddd;">User</th>
                <th style="padding: 10px; border: 1px solid #ddd;">Note</th>
            </tr>
        </thead>
        <tbody>
            @foreach($progressLogs as $log)
                <tr>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $log->task->project->name ?? 'N/A' }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $log->task->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $log->user->name }}</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">{{ $log->notes }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>