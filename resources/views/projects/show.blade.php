@extends('layout.mainlayout')

@section('name', $project->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-gray-300 text-[#0f0f0f] text-xs font-bold px-2.5 py-0.5 rounded">
                        {{ $project->client->name }}
                    </span>
                    <span class="text-gray-300 text-sm">|</span>
                    <span class="text-gray-300 text-sm">Due: {{ \Carbon\Carbon::parse($project->due_date)->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <h1 class="text-3xl font-bold text-[#e0bb35]">{{ $project->name }}</h1>
                    @if(Auth::user()->userRole->name === 'Admin')
                        <a href="{{ route('projects.edit', $project->id) }}" class="text-sm text-gray-400 hover:underline font-bold">Edit Project</a>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="text-right mr-2">
                    <p class="text-xs text-gray-300 uppercase tracking-wide">Current Status</p>
                    <p class="text-lg font-bold text-[#e0bb35]">{{ $project->status->name }}</p>
                </div>
                <div class="h-10 w-10 rounded-full flex items-center justify-center 
                    {{ $project->status->name == 'Finished' ? 'bg-green-500' : ($project->status->name == 'Cancelled' ? 'bg-red-500' : 'bg-blue-500') }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        <p class="text-gray-300 mt-4 border-t border-[#e0bb35] pt-4">
            {{ $project->description }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">

            @if(Auth::user()->userRole->name === 'Admin')
                <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                    <h3 class="text-xl font-bold mb-6 text-[#e0bb35]">Add New Task</h3>
                    <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Task Name</label>
                            <input type="text" name="name" required class="w-full rounded bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Description</label>
                            <textarea name="description" rows="2" class="w-full rounded bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Assign To (PIC)</label>
                            <select name="assigned_to" required class="w-full rounded bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                                @foreach($project->roleAssignments as $assignment)
                                    <option value="{{ $assignment->user->id }}">{{ $assignment->user->name }} ({{ $assignment->projectRole->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Due Date</label>
                            <input type="date" name="due_date" class="w-full rounded bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                        </div>
                        <div class="flex items-center mt-3">
                            <input id="is_hidden" name="is_hidden" type="checkbox" value="1" 
                                class="h-4 w-4 rounded border-gray-300 text-[#e0bb35] focus:ring-[#e0bb35] bg-[#0f0f0f]">
                            <label for="is_hidden" class="ml-2 block text-sm text-gray-300">
                                Mark as Hidden Task (Visible to Admin/Manager only)
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-[#e0bb35] text-black font-bold py-2 px-4 rounded-md hover:bg-[#e3cf85] transition">
                            Create Task
                        </button>
                    </form>
                </div>
            @endif

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h2 class="text-xl font-bold text-[#e0bb35] mb-6">Tasks</h2>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($project->tasks->sortByDesc('created_at') as $task)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-800" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-[#0f0f0f] flex items-center justify-center ring-2 ring-[#e0bb35]">
                                                <svg class="h-5 w-5 text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <p class="font-medium text-[#e0bb35]">
                                                {{ $task->name }}
                                            </p>
                                            <p class="text-sm text-gray-300">
                                                Assigned to <span class="font-medium text-[#e0bb35]">{{ $task->assigned->name ?? 'Unassigned' }}</span>
                                            </p>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-300">
                                                <time datetime="{{ $task->due_date }}">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</time>
                                            </div>
                                            <div class="h-5 w-5 rounded-full flex items-center justify-center 
                                                {{ $task->status->name == 'Finished' ? 'bg-green-500' : ($task->status->name == 'Cancelled' ? 'bg-red-500' : 'bg-blue-500') }}">
                                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </div>
                                            <p class="font-medium text-[#e0bb35] flex items-center gap-2">
                                                {{ $task->name }}
                                                
                                                @if($task->is_hidden)
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-700 text-gray-300 border border-gray-500">
                                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                                        Hidden
                                                    </span>
                                                @endif
                                            </p>
                                            @if(Auth::user()->userRole->name === 'Admin')
                                                <a href="{{ route('projects.tasks.edit', [$task->management_project_id, $task->id]) }}" class="text-[#e0bb35] hover:text-[#e3cf85] font-bold">Change Status</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h2 class="text-xl font-bold text-[#e0bb35] mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#e0bb35]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Update Progress
                </h2>
                <form action="{{ route('projects.progress.store', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#e0bb35]">New Task</label>
                            <select name="task_id" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                                <option value="">-- Select a Task --</option>
                                @foreach($project->tasks as $task)
                                    <option value="{{ $task->id }}">
                                        {{ $task->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#e0bb35]">Date</label>
                            <input type="date" name="progress_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#e0bb35]">Report Document (Required)</label>
                        <input type="file" name="document" required class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-gray-200 file:text-[#0f0f0f]
                            hover:file:bg-gray-100">
                        <p class="text-xs text-gray-300 mt-1">PDF, DOCX, or Image proofs.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#e0bb35]">Notes</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2" placeholder="Brief description of work done..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-[#e0bb35] text-black font-bold py-2 px-4 rounded-md hover:bg-[#e3cf85] transition">
                        Submit Report & Update Status
                    </button>
                </form>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h2 class="text-xl font-bold text-[#e0bb35] mb-6">Progress History</h2>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($project->progressLogs->sortByDesc('created_at') as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-800" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-[#0f0f0f] flex items-center justify-center ring-2 ring-[#e0bb35]">
                                                <svg class="h-5 w-5 text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-300">
                                                    Report for Task: <span class="font-medium text-[#e0bb35]">{{ $log->task->name ?? 'Unknown Task' }}</span> 
                                                    by <span class="font-medium text-[#e0bb35]">{{ $log->user->name }}</span>
                                                </p>
                                                <p class="text-sm text-gray-300 mt-1">{{ $log->notes }}</p>
                                                <a href="{{ asset('storage/' . $log->document_path) }}" target="_blank" class="inline-flex items-center mt-2 px-2.5 py-1.5 bg-[#e0bb35] border border-gray-800 shadow-sm text-xs font-medium rounded text-black hover:bg-[#e3cf85]">
                                                    View Document
                                                </a>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-300">
                                                <time datetime="{{ $log->progress_date }}">{{ \Carbon\Carbon::parse($log->progress_date)->format('M d, Y') }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>

        <div class="space-y-8">

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#e0bb35] mb-4">Project Team</h3>
                <ul class="divide-y divide-[#e0bb35]">
                    @foreach($project->roleAssignments as $assignment)
                        <li class="py-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-[#e0bb35] to-[#e3cf85] flex items-center justify-center text-black font-bold">
                                    {{ substr($assignment->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-[#e0bb35]">{{ $assignment->user->name }}</p>
                                    <p class="text-xs text-gray-300">{{ $assignment->projectRole->name }}</p>
                                </div>
                            </div>
                            
                            @if(Auth::user()->userRole->name === 'Admin')
                                <form action="{{ route('projects.team.destroy', [$project->id, $assignment->id]) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-600 transition-colors" title="Remove Member">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if(Auth::user()->userRole->name === 'Admin')
                    <a href="{{ route('projects.team.create', $project->id) }}" class="mt-4 w-full block text-center border border-dashed border-gray-200 text-[#e0bb35] py-2 rounded-md text-sm hover:bg-gray-200 hover:text-[#0f0f0f] transition">
                        + Assign Member (Admin)
                    </a>
                @endif
            </div>

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#e0bb35] mb-4">Allocated Products</h3>
                <ul class="space-y-3">
                    @forelse($project->productUsages as $usage)
                        <li class="flex justify-between items-center bg-[#0f0f0f] p-3 rounded-md group">
                            <div>
                                <p class="text-sm font-medium text-[#e0bb35]">{{ $usage->inventoryItem->product->name }}</p>
                                <p class="text-xs text-gray-300">Qty: <span class="font-bold">{{ $usage->quantity }}</span></p>
                            </div>
                            <div class="flex items-center gap-2">
                                @if(Auth::user()->userRole->name === 'Admin')
                                    <form action="{{ route('projects.allocation.destroy', [$project->id, $usage->id]) }}" method="POST" onsubmit="return confirm('Remove item? Stock will be returned.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-red-600 p-1" title="Remove & Return Stock">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-gray-300 italic text-center py-4">No products allocated yet.</p>
                    @endforelse
                </ul>
                @if(Auth::user()->userRole->name === 'Admin')
                    <a href="{{ route('projects.allocation.create', $project->id) }}" class="mt-4 w-full block text-center border border-dashed border-gray-200 text-[#e0bb35] py-2 rounded-md text-sm hover:bg-gray-200 hover:text-[#0f0f0f] transition">
                        + Allocate Product (Admin)
                    </a>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection