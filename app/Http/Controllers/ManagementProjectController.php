<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client; // Changed from App\Models\Clients\...
use App\Models\Managements\ManagementProject; // Changed from App\Models\Managements\...
use App\Models\Managements\Status; // Changed from App\Models\Managements\...
use App\Events\ManagementProjectFinished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementProjectController extends Controller
{
    /**
     * Display a listing of projects.
     */
    public function index()
    {
        // If Admin, show all. If Employee, show only assigned projects.
        $user = Auth::user();

        if ($user->userRole->name === 'Admin') {
            $projects = ManagementProject::with(['client', 'status'])->get();
        } else {
            // Get projects where the user has an assignment
            $projects = ManagementProject::whereHas('roleAssignments', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with(['client', 'status'])->get();
        }

        // Use the 'manage' view as per our previous refactoring
        return view('projects.manage', [
            'action' => 'list',
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $clients = Client::all();
        $statuses = Status::all();
        
        return view('projects.manage', [
            'action' => 'add',
            'clients' => $clients,
            'statuses' => $statuses,
            'project_to_edit' => null // Ensure variable exists for the view
        ]);
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'status_id' => 'required|exists:status,id',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        // Assign the creator as the initial Project Manager (optional logic)
        $validated['user_id'] = Auth::id(); 

        $project = ManagementProject::create($validated);

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project (Detail Dashboard).
     */
    public function show($id)
    {
        $project = ManagementProject::with([
            'client', 
            'status', 
            'roleAssignments.user', 
            'roleAssignments.projectRole',
            'progressLogs.user', // Load history
            'productUsages.inventoryItem.product' // Load BOM/Inventory
        ])->findOrFail($id);

        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit($id)
    {
        $project = ManagementProject::findOrFail($id);
        $clients = Client::all();
        $statuses = Status::all();

        return view('projects.manage', [
            'action' => 'edit',
            'project_to_edit' => $project,
            'clients' => $clients,
            'statuses' => $statuses
        ]);
    }

    /**
     * Update the specified project.
     * THIS IS WHERE THE MAGIC HAPPENS (Event Trigger).
     */
    public function update(Request $request, $id)
    {
        $project = ManagementProject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'status_id' => 'required|exists:status,id',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        // Update the project
        $project->update($validated);

        // --- AUTOMATION LOGIC ---
        // Check if status was changed to "Finished"
        $finishedStatus = Status::where('name', 'Finished')->first();

        if ($finishedStatus && 
            $project->wasChanged('status_id') && 
            $project->status_id == $finishedStatus->id) {
            
            // Fire the event to copy data to public site!
            ManagementProjectFinished::dispatch($project);
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from storage.
     */
    public function destroy($id)
    {
        $project = ManagementProject::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}