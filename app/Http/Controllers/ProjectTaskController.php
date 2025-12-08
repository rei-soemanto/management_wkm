<?php

namespace App\Http\Controllers;

use App\Models\Managements\ManagementProject;
use App\Models\Managements\ManagementProjectTask;
use App\Models\Managements\Status;
use App\Models\Users\User;
use Illuminate\Http\Request;
use App\Mail\TaskAssignedMail;
use Spatie\GoogleCalendar\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ProjectTaskController extends Controller
{
    // Store new task
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        $task = ManagementProjectTask::create([
            'management_project_id' => $projectId,
            'assigned_to' => $request->assigned_to,
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status_id' => 1,
            'is_hidden' => $request->has('is_hidden') ? true : false,
        ]);

        if ($task->assigned_to) {
            $user = User::find($request->assigned_to);
            Mail::to($user->email)->send(new TaskAssignedMail($task));

            if ($task->due_date) {
                $deadline = Carbon::parse($task->due_date->format('Y-m-d') . ' 20:00:00', 'Asia/Jakarta');
                
                $event = new Event;
                $event->name = 'Deadline: ' . $task->name;
                $event->description = $task->description;
                $event->startDateTime = $deadline;
                $event->endDateTime = $deadline->copy()->addHour();
                $event->addAttendee([
                    'email' => $user->email
                ]);
                $event->save();
            }
        }

        return back()->with('success', 'Task created successfully.');
    }

    // Show Manage Task page
    public function edit($projectId, $taskId)
    {
        $project = ManagementProject::with('roleAssignments.user')->findOrFail($projectId);
        $task = ManagementProjectTask::where('management_project_id', $projectId)->findOrFail($taskId);

        $statuses = Status::all();

        return view('projects.manage_task', compact('project', 'task', 'statuses'));
    }

    // Update Task
    public function update(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'status_id' => 'required|exists:status,id'
        ]);

        $task = ManagementProjectTask::where('management_project_id', $projectId)
            ->where('id', $taskId)
            ->firstOrFail();

        $oldAssigned = $task->assigned_to;
        $oldStatus = $task->status;

        $task->update([
            'name' => $request->name,
            'description' => $request->description,
            'assigned_to' => $request->assigned_to,
            'status_id' => $request->status_id,
            'due_date' => $request->due_date,
            'is_hidden' => $request->has('is_hidden') ? true : false,
        ]);

        return redirect()->route('projects.show', $projectId)->with('success', 'Task updated successfully.');
    }

    // Delete task
    public function destroy($projectId, $taskId)
    {
        $task = ManagementProjectTask::where('management_project_id', $projectId)
            ->where('id', $taskId)
            ->firstOrFail();
            
        $task->delete();

        return redirect()->route('projects.show', $projectId)->with('success', 'Task deleted.');
    }
}