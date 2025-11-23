<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * List all registered users.
     */
    public function index()
    {
        // Get all users with their roles
        $users = User::with('userRole')->latest()->get();
        
        return view('admin.user_manage.manage', [
            'action' => 'list',
            'users' => $users
        ]);
    }

    /**
     * Show edit form to change role.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = UserRole::all(); // Get Admin, Employee, User

        return view('admin.user_manage.manage', [
            'action' => 'edit',
            'user_to_edit' => $user,
            'roles' => $roles
        ]);
    }

    /**
     * Update user role.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'role_id' => 'required|exists:user_roles,id',
        ]);

        $user->update([
            'role_id' => $validated['role_id']
        ]);

        return redirect()->route('admin.user_manage.list')
            ->with('success', "User {$user->name}'s role updated successfully.");
    }
}