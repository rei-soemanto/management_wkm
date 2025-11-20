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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'status_id' => 'required|exists:status,id',
            'progress_date' => 'required|date',
            'document' => 'required|file|mimes:pdf,doc,docx,jpg,png|max:2048', // REQUIRED FILE
            'notes' => 'nullable|string',
        ]);

        $project = ManagementProject::findOrFail($projectId);

        // 1. Handle File Upload
        $path = $request->file('document')->store('project_documents', 'public');

        // 2. Create the Progress Log
        ManagementProjectProgress::create([
            'management_project_id' => $project->id,
            'user_id' => Auth::id(),
            'status_id' => $request->status_id,
            'progress_date' => $request->progress_date,
            'document_path' => $path,
            'notes' => $request->notes,
        ]);

        // 3. Automatically update the Main Project Status
        // The project status should always reflect the latest progress report
        $project->update(['status_id' => $request->status_id]);

        // (Optional) If this status is "Finished", the Event in ManagementProjectController
        // won't fire here automatically because we didn't use that controller.
        // You might want to manually check and fire it here too if needed.

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Progress report uploaded and status updated.');
    }
}