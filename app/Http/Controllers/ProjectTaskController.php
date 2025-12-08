<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Support\Facades\Log;
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

        $assignedUser = User::findOrFail($request->assigned_to);

        if ($request->has('is_hidden')) {
            $userRole = $assignedUser->userRole->name ?? '';
            
            if (!in_array($userRole, ['Admin', 'Manager'])) {
                return back()->with('error', 'Hidden tasks can only be assigned to Admin or Manager roles.')->withInput();
            }
        }

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

            $googleCalendarLink = null;

            if ($task->due_date) {
                $startDate = Carbon::parse($task->due_date)->setTime(12, 0, 0);
                $endDate   = $startDate->copy()->addHour();

                $startStr = $startDate->clone()->setTimezone('Asia/Jakarta')->format('Ymd\THis');
                $endStr   = $endDate->clone()->setTimezone('Asia/Jakarta')->format('Ymd\THis');

                $linkParams = [
                    'action'  => 'TEMPLATE',
                    'text'    => 'Deadline: ' . $task->name,
                    'details' => $task->description ?? 'No description',
                    'dates'   => $startStr . '/' . $endStr,
                    'ctz'     => 'Asia/Jakarta',
                ];

                $googleCalendarLink = 'https://calendar.google.com/calendar/render?' . http_build_query($linkParams);
                try {                    
                    $event = new Event;
                    $event->name = 'Deadline: ' . $task->name;
                    $event->description = $task->description;
                    $event->startDateTime = $startDate;
                    $event->endDateTime = $endDate;

                    $event->addAttendee(['email' => $user->email,]);

                    $event->save();

                } catch (Exception $e) {
                    Log::warning("Calendar API Error: " . $e->getMessage());
                }
            }

            Mail::to($user->email)->send(new TaskAssignedMail($task, $googleCalendarLink));
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