<?php

namespace App\Http\Controllers;

use App\Models\Managements\ManagementProject;
use App\Models\Managements\ManagementProjectTask;
use App\Models\Managements\ManagementProjectProgress;
use App\Models\Managements\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectTaskController extends Controller
{
    // Store a new task
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

    // Update task status (The new "Progress" workflow)
    public function updateStatus(Request $request, $projectId, $taskId)
    {
        $request->validate([
            'status' => 'required|in:Pending,In Progress,Completed,On Hold',
            'document' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:8192',
            'notes' => 'nullable|string'
        ]);

        $task = ManagementProjectTask::where('management_project_id', $projectId)
            ->where('id', $taskId)
            ->firstOrFail();

        // 1. Update Task Status
        $task->update(['status' => $request->status]);

        // 2. Log this in the main Project Progress History (so we keep a timeline)
        $project = ManagementProject::findOrFail($projectId);
        
        $documentPath = null;
        if ($request->hasFile('document')) {
            $documentPath = $request->file('document')->store('project_documents', 'public');
        }

        // Create a log entry
        ManagementProjectProgress::create([
            'management_project_id' => $projectId,
            'user_id' => Auth::id(),
            'status_id' => $project->status_id,
            'progress_date' => now(),
            'document_path' => $documentPath,
            'notes' => "Task '{$task->name}' updated to {$request->status}. " . $request->notes,
        ]);

        return back()->with('success', 'Task status updated.');
    }

    // Delete task
    public function destroy($projectId, $taskId)
    {
        $task = ManagementProjectTask::where('management_project_id', $projectId)
            ->where('id', $taskId)
            ->firstOrFail();
            
        $task->delete();

        return back()->with('success', 'Task deleted.');
    }
}