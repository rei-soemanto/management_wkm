@extends('layout.mainlayout')

@section('name', 'Manage All Users')

@section('content')
<main class="min-h-[597px] bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if ($action === 'edit')
            {{-- EDIT ROLE VIEW --}}
            <div class="max-w-xl mx-auto">
                <div class="mb-8">
                    <a href="{{ route('admin.user_manage.list') }}" class="text-sm text-white hover:text-[#e0bb35] flex items-center transition-colors font-bold uppercase">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Users
                    </a>
                    <h1 class="text-3xl font-bold text-[#e0bb35] mt-2 uppercase tracking-tight">Manage User Role</h1>
                </div>

                <div class="bg-[#0f0f0f] shadow-2xl rounded-xl overflow-hidden border border-gray-700 p-8">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-gray-800">
                        <div class="h-16 w-16 rounded-full bg-[#e0bb35] flex items-center justify-center text-black text-2xl font-black shadow-lg">
                            {{ substr($user_to_edit->name, 0, 1) }}
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-[#e0bb35]">{{ $user_to_edit->name }}</h2>
                            <p class="text-gray-400 text-sm font-medium">{{ $user_to_edit->email }}</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.user_manage.update', $user_to_edit->id) }}" method="POST" class="space-y-6">
                        @csrf @method('PUT')

                        <div>
                            <label for="role_id" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Assign System Role</label>
                            <select name="role_id" id="role_id" class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ $user_to_edit->role_id == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }} 
                                        @if($role->name === 'User') (Public Customer) @endif
                                        @if($role->name === 'Employee') (Internal Staff) @endif
                                        @if($role->name === 'Admin') (Super User) @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="mt-4 p-4 bg-red-900/20 border-l-2 border-red-500 rounded text-xs text-gray-300">
                                <strong class="text-red-400 uppercase">Warning:</strong> Downgrading to 'User' restricts all management access immediately.
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-800 flex justify-end gap-3">
                            <a href="{{ route('admin.user_manage.list') }}" class="px-6 py-2 bg-white text-black rounded-md font-bold text-xs uppercase hover:bg-gray-200 transition-colors">Cancel</a>
                            <button type="submit" class="px-6 py-2 bg-[#e0bb35] rounded-md font-bold text-xs text-black uppercase hover:bg-[#f2cc4a] transition-colors shadow-lg">
                                Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @else
            {{-- LIST VIEW --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-[#e0bb35] tracking-tight">Registered Users</h1>
                    <p class="text-white mt-1 font-medium">Global directory of registered system users.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 w-full md:max-w-2xl">
                    <form method="GET" action="{{ route('admin.user_manage.list') }}" class="w-full flex gap-4">
                        <select name="role" onchange="this.form.submit()" 
                            class="bg-[#0f0f0f] border border-gray-700 text-gray-300 text-sm rounded-lg py-2 px-3 focus:ring-2 focus:ring-[#e0bb35] outline-none">
                            <option value="">All Roles</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                            @endforeach
                        </select>

                        <div class="relative flex-1 group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email..." 
                                class="w-full bg-[#0f0f0f] text-white border border-gray-700 rounded-lg py-2.5 px-4 pl-10 focus:ring-2 focus:ring-[#e0bb35] outline-none">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl shadow-2xl overflow-hidden border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead class="bg-black">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest">User</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest hidden lg:table-cell">Contact</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Access Level</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Status</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @foreach($users as $user)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="h-9 w-9 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center text-[#e0bb35] font-black text-xs uppercase">
                                                {{ substr($user->name, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-[#e0bb35]">{{ $user->name }}</div>
                                                <div class="text-[10px] text-white/50 lg:hidden max-w-[150px] truncate" title="{{ $user->email }}">{{ $user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        <div class="text-sm text-white font-medium max-w-[200px] truncate" title="{{ $user->email }}">{{ $user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $role = $user->userRole->name ?? 'User';
                                            $color = match($role) {
                                                'Admin' => 'border-purple-500/50 text-purple-400 bg-purple-500/10',
                                                'Manager' => 'border-green-500/50 text-green-400 bg-green-500/10',
                                                'Employee' => 'border-blue-500/50 text-blue-400 bg-blue-500/10',
                                                default => 'border-gray-500/50 text-gray-400 bg-gray-500/10',
                                            };
                                        @endphp
                                        <span class="px-3 py-1 text-[10px] font-bold rounded border uppercase tracking-tighter {{ $color }}">
                                            {{ $role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($role === 'User')
                                            <span class="text-[10px] text-red-500 font-bold uppercase flex items-center justify-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" /></svg>
                                                No Access
                                            </span>
                                        @else
                                            <span class="text-[10px] text-green-500 font-bold uppercase flex items-center justify-center">
                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                                                Authorized
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('admin.user_manage.edit', $user->id) }}" 
                                                class="bg-[#e0bb35] hover:bg-[#f2cc4a] text-black text-[10px] font-bold py-1.5 px-3 rounded uppercase transition-all shadow-md">
                                                Edit
                                            </a>

                                            <button type="button" 
                                                class="sidebar-details-trigger bg-gray-800 hover:bg-gray-700 text-white text-[10px] font-bold py-1.5 px-3 rounded uppercase border border-gray-600 transition-all shadow-md"
                                                data-sidebar-title="User Profile"
                                                data-sidebar-schema="{{ json_encode([
                                                    ['type' => 'header', 'label' => 'Full Name', 'value' => $user->name],
                                                    ['type' => 'lead', 'value' => 'System security profile and access logs for ' . $user->name . '.'],
                                                    ['type' => 'grid', 'items' => [
                                                        ['label' => 'Role', 'value' => $role],
                                                        ['label' => 'System Status', 'value' => ($role === 'User' ? 'Restricted' : 'Active Personnel')],
                                                        ['label' => 'Email', 'value' => $user->email],
                                                        ['label' => 'Created', 'value' => $user->created_at ? $user->created_at->format('M d, Y') : 'N/A']
                                                    ]],
                                                ]) }}">
                                                Details
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                <style>
                    nav[role="navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between div:first-child p { color: #9ca3af !important; }
                    nav[role="navigation"] span[aria-current="page"] span { background-color: #e0bb35 !important; color: black !important; border-color: #e0bb35 !important; font-weight: bold; }
                    nav[role="navigation"] a { background-color: #0f0f0f !important; color: white !important; border-color: #374151 !important; }
                </style>
                {{ $users->links() }}
            </div>
        @endif
    </div>
</main>
@endsection