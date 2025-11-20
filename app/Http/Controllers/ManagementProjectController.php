<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client;
use App\Models\Managements\ManagementProject;
use App\Models\Managements\Status;
use App\Models\Managements\ProjectRole;
use App\Models\Users\User;
use App\Events\ManagementProjectFinished; // Import the Event
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

        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        $clients = Client::all();
        $statuses = Status::all();
        return view('projects.create', compact('clients', 'statuses'));
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
}