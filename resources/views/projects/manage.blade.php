@extends('layout.mainlayout')

@section('name', 'Internal Projects')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    @if ($action === 'add' || $action === 'edit')
        {{-- CREATE/EDIT VIEW --}}
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('projects.index') }}" class="text-sm text-white hover:text-[#e0bb35] flex items-center transition-colors font-bold uppercase">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Projects
                </a>
                <h1 class="text-3xl font-bold text-[#e0bb35] mt-2 uppercase tracking-tight">
                    {{ $action === 'edit' ? 'Edit Project' : 'Create Project' }}
                </h1>
            </div>

            <div class="bg-[#0f0f0f] shadow-2xl rounded-xl overflow-hidden border border-gray-700">
                <form action="{{ $action === 'edit' ? route('projects.update', $project_to_edit->id) : route('projects.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @if ($action === 'edit') @method('PUT') @endif

                    <div>
                        <label for="name" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Project Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $project_to_edit->name ?? '') }}" required 
                            class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Project Scope Categories</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 bg-black border border-gray-800 p-4 rounded-md">
                            @foreach($categories as $category)
                                <div class="flex items-center">
                                    <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="cat_{{ $category->id }}"
                                        @checked(is_array(old('category_ids')) ? in_array($category->id, old('category_ids')) : ($project_to_edit && $project_to_edit->categories->contains($category->id)))
                                        class="h-4 w-4 rounded border-gray-700 bg-[#1a1a1a] text-[#e0bb35] focus:ring-[#e0bb35]">
                                    <label for="cat_{{ $category->id }}" class="ml-2 text-sm text-gray-400">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="client_id" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Client</label>
                            <select name="client_id" id="client_id" required 
                                class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all">
                                <option value="">Select Client...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" @selected(old('client_id', $project_to_edit->client_id ?? '') == $client->id)>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status_id" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Status</label>
                            <select name="status_id" id="status_id" required 
                                class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id', $project_to_edit->status_id ?? '') == $status->id)>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="start_date" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">SPO Date</label>
                            <input type="date" name="start_date" id="start_date" 
                                value="{{ old('start_date', isset($project_to_edit->start_date) ? $project_to_edit->start_date->format('Y-m-d') : '') }}" required 
                                class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all [&::-webkit-calendar-picker-indicator]:invert">
                        </div>

                        <div>
                            <label for="due_date" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Due Date</label>
                            <input type="date" name="due_date" id="due_date" 
                                value="{{ old('due_date', isset($project_to_edit->due_date) ? $project_to_edit->due_date->format('Y-m-d') : '') }}" required 
                                class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all [&::-webkit-calendar-picker-indicator]:invert">
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Description / Scope</label>
                        <textarea name="description" id="description" rows="4" 
                            class="block w-full bg-black border border-gray-700 rounded-md text-white py-3 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all">{{ old('description', $project_to_edit->description ?? '') }}</textarea>
                    </div>

                    <div class="pt-6 border-t border-gray-800 flex justify-end gap-3">
                        <a href="{{ route('projects.index') }}" class="px-6 py-2 bg-white text-black rounded-md font-bold text-xs uppercase hover:bg-gray-200 transition-colors">Cancel</a>
                        <button type="submit" class="px-6 py-2 bg-[#e0bb35] rounded-md font-bold text-xs text-black uppercase hover:bg-[#f2cc4a] transition-colors shadow-lg">
                            {{ $action === 'edit' ? 'Update Project' : 'Create Project' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        {{-- LIST VIEW (CARD SYSTEM) --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-bold text-[#e0bb35] tracking-tight">Internal Projects</h1>
                <p class="text-white mt-1 font-medium">Operational overview and team assignments.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:max-w-2xl">
                <form method="GET" action="{{ route('projects.index') }}" class="relative flex-1 group w-full">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search project, client..." 
                        class="w-full bg-[#0f0f0f] text-white border border-gray-700 rounded-lg py-2.5 px-4 pl-10 focus:ring-2 focus:ring-[#e0bb35] outline-none">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                </form>

                @if(Auth::user()->userRole->name === 'Admin')
                    <a href="{{ route('projects.create') }}" class="w-full sm:w-auto px-6 py-2.5 bg-[#e0bb35] rounded-lg font-bold text-xs text-black uppercase hover:bg-[#f2cc4a] transition-all shadow-lg flex items-center justify-center whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        New Project
                    </a>
                @endif
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-900/30 border-l-4 border-green-500 text-white p-4 mb-6 rounded shadow-lg backdrop-blur-sm">
                <span class="font-bold">Success:</span> {{ session('success') }}
            </div>
        @endif

        @if($projects->isEmpty())
            <div class="bg-[#0f0f0f] rounded-xl p-16 text-center border border-gray-700 border-dashed">
                <div class="bg-gray-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <h3 class="text-xl font-bold text-[#e0bb35] uppercase">No Projects Assigned</h3>
                <p class="text-gray-400 mt-2">No operational projects match your current criteria or assignments.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    @php
                        $user = Auth::user();
                        $isPrivileged = in_array($user->userRole->name, ['Admin', 'Manager']);
                        $isAssigned = $project->roleAssignments->contains('user_id', $user->id);
                        
                        $statusName = $project->status->name ?? 'Unknown';
                        $statusStyles = match($statusName) {
                            'Finished' => 'border-green-500/50 text-green-400 bg-green-500/10',
                            'In Progress' => 'border-blue-500/50 text-blue-400 bg-blue-500/10',
                            'Pending' => 'border-yellow-500/50 text-yellow-400 bg-yellow-500/10',
                            'Cancelled' => 'border-red-500/50 text-red-400 bg-red-500/10',
                            default => 'border-gray-500/50 text-gray-400 bg-gray-500/10',
                        };
                    @endphp

                    @if($isPrivileged || $isAssigned)
                        <div class="group relative bg-[#0f0f0f] rounded-xl border border-gray-700 hover:border-[#e0bb35]/50 transition-all duration-300 shadow-2xl flex flex-col">
                            <div class="p-6 grow">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="px-2 py-1 bg-white/5 border border-white/10 rounded text-[10px] font-bold text-gray-400 tracking-tighter">
                                        {{ $project->client->name ?? 'No Client' }}
                                    </span>
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded border uppercase tracking-tighter {{ $statusStyles }}">
                                        {{ $statusName }}
                                    </span>
                                </div>
                                
                                <h3 class="text-lg font-bold text-white mb-2 leading-tight group-hover:text-[#e0bb35] transition-colors">
                                    {{ $project->name }}
                                </h3>
                                
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5 mr-2 text-[#e0bb35]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        <span class="font-bold mr-1">SPO:</span> {{ $project->start_date ? $project->start_date->format('M d, Y') : 'N/A' }}
                                    </div>
                                    <div class="flex items-center text-xs text-gray-400">
                                        <svg class="w-3.5 h-3.5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                        <span class="font-bold mr-1 text-red-500/80">DUE:</span> {{ $project->due_date ? $project->due_date->format('M d, Y') : 'N/A' }}
                                    </div>
                                </div>

                                <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">
                                    {{ $project->description ?? 'No scope defined for this project.' }}
                                </p>
                            </div>

                            <div class="px-6 py-4 bg-black/40 border-t border-gray-800 rounded-b-xl flex justify-between items-center">
                                <div class="flex -space-x-2">
                                    @foreach($project->roleAssignments->take(4) as $assignment)
                                        <div class="h-7 w-7 rounded-full border-2 border-[#0f0f0f] bg-gray-800 flex items-center justify-center text-[10px] font-bold text-[#e0bb35] uppercase" title="{{ $assignment->user->name }}">
                                            {{ substr($assignment->user->name, 0, 1) }}
                                        </div>
                                    @endforeach
                                    @if($project->roleAssignments->count() > 4)
                                        <div class="h-7 w-7 rounded-full border-2 border-[#0f0f0f] bg-[#e0bb35] flex items-center justify-center text-[10px] font-bold text-black">
                                            +{{ $project->roleAssignments->count() - 4 }}
                                        </div>
                                    @endif
                                </div>
                                <a href="{{ route('projects.show', $project->id) }}" class="text-[10px] font-bold text-[#e0bb35] uppercase tracking-widest hover:text-white transition-colors flex items-center">
                                    Details
                                    <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-8">
                <style>
                    nav[role="navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between div:first-child p { color: #9ca3af !important; }
                    nav[role="navigation"] span[aria-current="page"] span { background-color: #e0bb35 !important; color: black !important; border-color: #e0bb35 !important; font-weight: bold; }
                    nav[role="navigation"] a { background-color: #0f0f0f !important; color: white !important; border-color: #374151 !important; }
                </style>
                {{ $projects->links() }}
            </div>
        @endif
    @endif
</div>
@endsection