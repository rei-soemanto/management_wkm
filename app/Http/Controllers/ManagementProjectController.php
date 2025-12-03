<?php

namespace App\Http\Controllers;

use App\Models\Clients\Client;
use App\Models\Managements\ManagementProject;
use App\Models\Managements\Status;
use App\Models\Projects\ProjectCategory;
use App\Events\ManagementProjectFinished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManagementProjectController extends Controller
{
    // Display list of projects.
    public function index()
    {
        // If Admin, show all. If Employee, show only assigned projects.
        $user = Auth::user();

        if (in_array($user->userRole->name, ['Admin', 'Manager'])) {
            $projects = ManagementProject::with(['client', 'status'])->get();
        } else {
            // Get projects where the user has an assignment
            $projects = ManagementProject::whereHas('roleAssignments', function($q) use ($user) {
                $q->where('user_id', $user->id);
            })->with(['client', 'status'])->get();
        }

        return view('projects.manage', [
            'action' => 'list',
            'projects' => $projects
        ]);
    }

    // Show the form for creating a new project.
    public function create()
    {
        $clients = Client::all();
        $statuses = Status::all();
        $categories = ProjectCategory::all();
        
        return view('projects.manage', [
            'action' => 'add',
            'clients' => $clients,
            'statuses' => $statuses,
            'categories' => $categories,
            'project_to_edit' => null
        ]);
    }

    // Store newly created project in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'status_id' => 'required|exists:status,id',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:project_categories,id',
        ]);

        $validated['user_id'] = Auth::id(); 

        $project = ManagementProject::create($validated);

        if ($request->has('category_ids')) {
            $project->categories()->attach($request->category_ids);
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project created successfully.');
    }

    // Display specified project.
    public function show($id)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        $roleName = optional($user->userRole)->name;
        $canSeeHidden = in_array($user->userRole->name, ['Admin', 'Manager']);

        $project = ManagementProject::with([
            'client', 
            'status', 
            'roleAssignments.user', 
            'roleAssignments.projectRole',
            'productUsages.inventoryItem.product',

            'tasks' => function($query) use ($canSeeHidden) {
                if (!$canSeeHidden) {
                    $query->where('is_hidden', false);
                }
            },
            
            'progressLogs' => function($query) use ($canSeeHidden) {
                $query->with('user', 'task');
                
                if (!$canSeeHidden) {
                    $query->whereHas('task', function($q) {
                        $q->where('is_hidden', false);
                    });
                }
            }
        ])->findOrFail($id);

        return view('projects.show', compact('project', 'canSeeHidden'));
    }

    // Show form for edit specified project.
    public function edit($id)
    {
        $project = ManagementProject::findOrFail($id);
        $clients = Client::all();
        $statuses = Status::all();
        $categories = ProjectCategory::all();

        return view('projects.manage', [
            'action' => 'edit',
            'project_to_edit' => $project,
            'clients' => $clients,
            'statuses' => $statuses,
            'categories' => $categories,
        ]);
    }

    // Update specified project.
    public function update(Request $request, $id)
    {
        $project = ManagementProject::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'status_id' => 'required|exists:status,id',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:project_categories,id',
        ]);

        // Update project
        $project->update($validated);

        if ($request->has('category_ids')) {
            $project->categories()->sync($request->category_ids);
        } else {
            $project->categories()->detach();
        }

        // Check if status changed to Finished
        $finishedStatus = Status::where('name', 'Finished')->first();

        if ($finishedStatus && 
            $project->wasChanged('status_id') && 
            $project->status_id == $finishedStatus->id) {
            
            // Fire event to copy data to public site
            ManagementProjectFinished::dispatch($project);
        }

        return redirect()->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully.');
    }

    // Remove specified project from storage.
    public function destroy($id)
    {
        $project = ManagementProject::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}