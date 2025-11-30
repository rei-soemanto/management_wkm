<?php

namespace App\Http\Controllers;

use App\Models\Managements\ManagementProject;
use App\Models\Managements\ManagementProjectProgress;
use App\Models\Managements\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManagementProjectProgressController extends Controller
{
    // Store newly created resource in storage.
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'task_id' => 'required|exists:management_project_tasks,id',
            'progress_date' => 'required|date',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:8192',
            'notes' => 'nullable|string',
        ]);

        $project = ManagementProject::findOrFail($projectId);

        // Handle File Upload
        $path = $request->file('document')->store('project_documents', 'public');

        // Create Progress Log
        ManagementProjectProgress::create([
            'management_project_id' => $project->id,
            'user_id' => Auth::id(),
            'task_id' => $request->task_id,
            'progress_date' => $request->progress_date,
            'document_path' => $path,
            'notes' => $request->notes,
        ]);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Progress report uploaded and status updated.');
    }
}