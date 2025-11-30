<?php

namespace App\Http\Controllers;

use App\Models\Managements\ManagementProject;
use App\Models\Managements\ManagementProjectTask;
use Illuminate\Http\Request;

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

        ManagementProjectTask::create([
            'management_project_id' => $projectId,
            'assigned_to' => $request->assigned_to,
            'name' => $request->name,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => 'Pending'
        ]);

        return back()->with('success', 'Task created successfully.');
    }

    // Show Manage Task page
    public function edit($projectId, $taskId)
    {
        $project = ManagementProject::with('roleAssignments.user')->findOrFail($projectId);
        $task = ManagementProjectTask::where('management_project_id', $projectId)->findOrFail($taskId);

        return view('projects.manage_task', compact('project', 'task'));
    }

    // Update Task
    public function update(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to' => 'required|exists:users,id',
            'status' => 'required|in:Pending,In Progress,Completed,On Hold',
            'due_date' => 'nullable|date',
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
            'status' => $request->status,
            'due_date' => $request->due_date,
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