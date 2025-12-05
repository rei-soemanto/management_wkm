@extends('layout.mainlayout')

@section('name', 'Manage All Users')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if ($action === 'edit')
        
        <div class="max-w-xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('admin.user_manage.list') }}" class="text-sm text-gray-300 hover:text-gray-400 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Users
                </a>
                <h1 class="text-3xl font-bold text-[#e0bb35] mt-2">Manage User Role</h1>
            </div>

            <div class="bg-[#0f0f0f] shadow-lg rounded-xl overflow-hidden border border-gray-800 p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="h-16 w-16 rounded-full bg-[#e0bb35] flex items-center justify-center text-black text-2xl font-bold">
                        {{ substr($user_to_edit->name, 0, 1) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-[#e0bb35]">{{ $user_to_edit->name }}</h2>
                        <p class="text-gray-300">{{ $user_to_edit->email }}</p>
                    </div>
                </div>

                <form action="{{ route('admin.user_manage.update', $user_to_edit->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-6">
                        <label for="role_id" class="block text-sm font-bold text-[#e0bb35] mb-2">Assign Role</label>
                        <select name="role_id" id="role_id" class="block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 p-2.5">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" 
                                    {{ $user_to_edit->role_id == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }} 
                                    @if($role->name === 'User') (Public Customer) @endif
                                    @if($role->name === 'Employee') (Internal Staff) @endif
                                    @if($role->name === 'Admin') (Super User) @endif
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-2 text-sm text-gray-300">
                            <strong>Warning:</strong> Changing a role to 'User' will block them from accessing this Management Site immediately.
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('admin.user_manage.list') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-[#e0bb35] border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-[#e3cf85] shadow-sm transition-colors">
                            Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-[#e0bb35]">All Registered Users</h1>
                <p class="text-gray-300 mt-1">Manage access control and user roles.</p>
            </div>
            <form method="GET" action="{{ route('users.index') }}" class="w-2/3 md:w-1/3">
                <div class="relative">
                    <input type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search name or email..." 
                            class="w-full bg-[#0f0f0f] border border-[#e0bb35] text-gray-300 rounded-md py-2 px-4 focus:outline-none focus:ring-1 focus:ring-[#e0bb35]">
                    <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-[#e0bb35]">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
            </form>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-[#0f0f0f] shadow overflow-hidden sm:rounded-lg border border-gray-800">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-[#0f0f0f]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Current Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-[#0f0f0f] divide-y divide-gray-800">
                    @foreach($users as $user)
                    <tr class="hover:bg-black">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-[#e0bb35] flex items-center justify-center text-black font-bold">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-[#e0bb35]">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $roleName = $user->userRole->name ?? 'User';
                                $badgeColor = match($roleName) {
                                    'Admin' => 'bg-purple-100 text-purple-800',
                                    'Employee' => 'bg-blue-100 text-blue-800',
                                    default => 'bg-gray-100 text-gray-800',
                                };
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                {{ $roleName }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($roleName === 'User')
                                <span class="text-xs text-red-600 font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    No Access
                                </span>
                            @else
                                <span class="text-xs text-green-600 font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Authorized
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.user_manage.edit', $user->id) }}" class="text-[#e0bb35] hover:text-[#e3cf85] font-bold">Change Role</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="bg-[#0f0f0f] shadow overflow-hidden sm:rounded-lg border border-gray-800">
            <table class="min-w-full divide-y divide-gray-800">
                <style>
                    nav[role="navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between div:first-child p {
                        color: #9ca3af;
                    }
                    nav[role="navigation"] span[aria-current="page"] span {
                        background-color: #e0bb35 !important;
                        color: black !important;
                        border-color: #e0bb35 !important;
                    }
                    nav[role="navigation"] a {
                        background-color: #0f0f0f !important;
                        color: white !important;
                        border-color: #374151 !important;
                    }
                    nav[role="navigation"] span[aria-disabled="true"] span {
                        background-color: #0f0f0f !important;
                        color: #6b7280 !important;
                        border-color: #374151 !important;
                    }
                </style>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    @endif
</div>
@endsection