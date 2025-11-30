<?php

namespace App\Http\Controllers;

use App\Models\Managements\ManagementProject;
use App\Models\Managements\ManagementProjectRoleAssignment;
use App\Models\Managements\ProjectRole;
use App\Models\Users\User;
use Illuminate\Http\Request;

class ProjectTeamController extends Controller
{
    // Show Assign Member form
    public function create($projectId)
    {
        $project = ManagementProject::findOrFail($projectId);
        
        // Get users
        $users = User::whereHas('userRole')->get();
        
        $roles = ProjectRole::all();

        return view('projects.assign_member', compact('project', 'users', 'roles'));
    }

    // Store assignment
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:project_roles,id',
        ]);

        $exists = ManagementProjectRoleAssignment::where('management_project_id', $projectId)
            ->where('user_id', $request->user_id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'This user is already assigned to this project.');
        }

        ManagementProjectRoleAssignment::create([
            'management_project_id' => $projectId,
            'user_id' => $request->user_id,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('projects.show', $projectId)->with('success', 'Team member assigned successfully.');
    }

    // Remove member
    public function destroy($projectId, $assignmentId)
    {
        $assignment = ManagementProjectRoleAssignment::where('management_project_id', $projectId)
            ->where('id', $assignmentId)
            ->firstOrFail();

        $assignment->delete();

        return redirect()->route('projects.show', $projectId)->with('success', 'Member removed from project.');
    }
}