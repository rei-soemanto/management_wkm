<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Users\User;
use App\Models\Users\UserRole;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('userRole')->orderBy('id', 'asc');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(5)->withQueryString();
        
        return view('admin.user_manage.manage', [
            'action' => 'list',
            'users' => $users
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = UserRole::all();

        return view('admin.user_manage.manage', [
            'action' => 'edit',
            'user_to_edit' => $user,
            'roles' => $roles
        ]);
    }

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