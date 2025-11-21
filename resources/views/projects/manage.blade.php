@extends('layout.mainlayout')

@section('name', 'Internal Projects')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if ($action === 'add' || $action === 'edit')
        
        {{-- ===========================
             FORM VIEW (Add / Edit)
           =========================== --}}
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('projects.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Projects
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">{{ $action === 'edit' ? 'Edit Project' : 'Create New Internal Project' }}</h1>
                <p class="text-gray-500 mt-1">Manage operational project details.</p>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
                <form action="{{ $action === 'edit' ? route('projects.update', $project_to_edit->id) : route('projects.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @if ($action === 'edit')
                        @method('PUT')
                    @endif

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-1">Project Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $project_to_edit->name ?? '') }}" required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3">
                    </div>

                    {{-- Client & Status --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="client_id" class="block text-sm font-bold text-gray-700 mb-1">Client</label>
                            <select name="client_id" id="client_id" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3">
                                <option value="">Select Client...</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" @selected(old('client_id', $project_to_edit->client_id ?? '') == $client->id)>{{ $client->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="status_id" class="block text-sm font-bold text-gray-700 mb-1">Status</label>
                            <select name="status_id" id="status_id" required 
                                class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3">
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id', $project_to_edit->status_id ?? '') == $status->id)>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Due Date --}}
                    <div>
                        <label for="due_date" class="block text-sm font-bold text-gray-700 mb-1">Target Due Date</label>
                        <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $project_to_edit->due_date ?? '') }}" required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-1">Description / Scope</label>
                        <textarea name="description" id="description" rows="4" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm py-2 px-3">{{ old('description', $project_to_edit->description ?? '') }}</textarea>
                    </div>

                    {{-- Actions --}}
                    <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('projects.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                            {{ $action === 'edit' ? 'Update Project' : 'Create Project' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        
        {{-- ===========================
             LIST VIEW (Cards)
           =========================== --}}
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Internal Projects</h1>
                <p class="text-gray-500 mt-1">
                    @if(Auth::user()->userRole->name === 'Admin')
                        Managing all operational projects
                    @else
                        Projects you are assigned to
                    @endif
                </p>
            </div>

            @if(Auth::user()->userRole->name === 'Admin')
                <a href="{{ route('projects.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-sm transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    New Project
                </a>
            @endif
        </div>

        {{-- Notifications --}}
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                {{ session('success') }}
            </div>
        @endif

        {{-- Content --}}
        @if($projects->isEmpty())
            <div class="bg-white rounded-lg shadow-sm p-12 text-center border border-gray-200">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">No Projects Found</h3>
                <p class="text-gray-500 mt-1">There are no active projects assigned to you yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <a href="{{ route('projects.show', $project->id) }}" class="block group">
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md border border-gray-200 transition-all duration-200 h-full flex flex-col">
                            {{-- Card Header --}}
                            <div class="p-5 border-b border-gray-100 flex justify-between items-start">
                                <div>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mb-2">
                                        {{ $project->client->name ?? 'No Client' }}
                                    </span>
                                    <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors">
                                        {{ $project->name }}
                                    </h3>
                                </div>
                                
                                {{-- Status Badge --}}
                                @php
                                    $statusColor = match($project->status->name ?? '') {
                                        'Finished' => 'bg-green-100 text-green-800',
                                        'In Progress' => 'bg-blue-100 text-blue-800',
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Cancelled' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $statusColor }}">
                                    {{ $project->status->name ?? 'Unknown' }}
                                </span>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5 flex-grow">
                                <div class="flex items-center text-sm text-gray-500 mb-4">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Due: {{ $project->due_date ? \Carbon\Carbon::parse($project->due_date)->format('M d, Y') : 'No Deadline' }}
                                </div>
                                <p class="text-sm text-gray-600 line-clamp-3">
                                    {{ $project->description ?? 'No description provided.' }}
                                </p>
                            </div>

                            {{-- Card Footer --}}
                            <div class="bg-gray-50 p-4 rounded-b-xl flex justify-between items-center">
                                <div class="flex -space-x-2 overflow-hidden">
                                    @foreach($project->roleAssignments->take(3) as $assignment)
                                        <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-blue-500 flex items-center justify-center text-white text-xs font-bold" title="{{ $assignment->user->name }}">
                                            {{ substr($assignment->user->name, 0, 1) }}
                                        </div>
                                    @endforeach
                                    @if($project->roleAssignments->count() > 3)
                                        <div class="inline-block h-8 w-8 rounded-full ring-2 ring-white bg-gray-200 flex items-center justify-center text-gray-600 text-xs font-bold">
                                            +{{ $project->roleAssignments->count() - 3 }}
                                        </div>
                                    @endif
                                </div>
                                <span class="text-sm text-blue-600 font-medium group-hover:underline">View Details &rarr;</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

    @endif
</div>
@endsection