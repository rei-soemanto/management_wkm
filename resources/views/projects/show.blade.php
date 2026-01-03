@extends('layout.mainlayout')

@section('name', $project->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 md:py-8">

    <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-4 md:p-6 mb-8">
        <div class="flex flex-col lg:flex-row justify-between lg:items-center gap-6">
            <div class="w-full lg:max-w-3/4">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="bg-gray-300 text-[#0f0f0f] text-xs font-bold px-2.5 py-0.5 rounded">
                        {{ $project->client->name }}
                    </span>
                    <span class="hidden sm:inline text-gray-600 text-sm">|</span>
                    <div class="flex flex-wrap gap-2 text-gray-400 text-xs sm:text-sm">
                        <span>SPO: {{ \Carbon\Carbon::parse($project->start_date)->format('M d, Y')}}</span>
                        <span>-</span>
                        <span>Due: {{ \Carbon\Carbon::parse($project->due_date)->format('M d, Y') }}</span>
                    </div>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-[#e0bb35] leading-tight">{{ $project->name }}</h1>
                    @if(Auth::user()->userRole->name === 'Admin')
                        <a href="{{ route('projects.edit', $project->id) }}" class="text-xs text-gray-400 hover:text-[#e0bb35] underline font-bold transition">Edit Project</a>
                    @endif
                </div>

                <div class="flex flex-wrap items-center gap-2 mt-3">
                    @foreach($project->categories as $category)
                        <span class="border border-[#e0bb35] text-[#e0bb35] text-[10px] sm:text-xs font-bold px-2 py-0.5 rounded uppercase">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            
            <div class="flex items-center lg:justify-end gap-3 lg:bg-transparent p-3 lg:p-0 rounded-lg">
                <div class="text-left lg:text-right">
                    <p class="text-[10px] text-gray-400 uppercase tracking-widest">Current Status</p>
                    <p class="text-base md:text-lg font-bold text-[#e0bb35]">{{ $project->status->name }}</p>
                </div>
                <div class="h-10 w-10 rounded-full flex items-center justify-center shrink-0
                    {{ $project->status->name == 'Finished' ? 'bg-green-500' : ($project->status->name == 'Cancelled' ? 'bg-red-500' : 'bg-blue-600') }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        <div class="text-gray-300 mt-6 border-t border-gray-800 pt-4 text-sm leading-relaxed">
            {{ $project->description }}
        </div>
    </div>

    @if (session('error'))
        <div class="bg-red-900/20 border-l-4 border-red-500 text-red-400 p-4 mb-6 rounded shadow-md text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">

            @if(Auth::user()->userRole->name === 'Admin')
                <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                    <h3 class="text-xl font-bold mb-6 text-[#e0bb35]">Add New Task</h3>
                    <form action="{{ route('projects.tasks.store', $project->id) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @csrf
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Task Name</label>
                            <input type="text" name="name" required class="w-full rounded bg-[#1a1a1a] border-gray-700 focus:border-[#e0bb35] focus:ring-[#e0bb35] text-gray-300 px-3 py-2">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Description</label>
                            <textarea name="description" rows="2" class="w-full rounded bg-[#1a1a1a] border-gray-700 focus:border-[#e0bb35] focus:ring-[#e0bb35] text-gray-300 px-3 py-2"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Assign To (PIC)</label>
                            <select name="assigned_to" required class="w-full rounded bg-[#1a1a1a] border-gray-700 text-gray-300 px-3 py-2">
                                @foreach($project->roleAssignments as $assignment)
                                    <option value="{{ $assignment->user->id }}">{{ $assignment->user->name }} ({{ $assignment->projectRole->name }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1 text-[#e0bb35]">Due Date</label>
                            <input type="date" name="due_date" class="w-full rounded bg-[#1a1a1a] border-gray-700 text-gray-300 px-3 py-2 [&::-webkit-calendar-picker-indicator]:invert">
                        </div>
                        <div class="md:col-span-2 flex items-center py-2">
                            <input id="is_hidden" name="is_hidden" type="checkbox" value="1" class="h-4 w-4 rounded border-gray-700 text-[#e0bb35] focus:ring-[#e0bb35] bg-[#1a1a1a]">
                            <label for="is_hidden" class="ml-2 block text-sm text-gray-400">
                                Mark as Hidden Task (Visible to Admin/Manager only)
                            </label>
                        </div>
                        <div class="md:col-span-2">
                            <button type="submit" class="w-full bg-[#e0bb35] text-black font-bold py-2.5 rounded-md hover:bg-[#c9a72e] transition">
                                Create Task
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h2 class="text-xl font-bold text-[#e0bb35] mb-6">Tasks</h2>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($project->tasks->sortByDesc('created_at') as $task)
                            <li class="relative pb-8">
                                @if(!$loop->last)
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-800"></span>
                                @endif
                                <div class="relative flex flex-col sm:flex-row items-start space-x-0 sm:space-x-3 gap-3 sm:gap-0">
                                    <div class="shrink-0">
                                        <span class="h-8 w-8 rounded-full bg-[#0f0f0f] flex items-center justify-center ring-2 ring-[#e0bb35]">
                                            <svg class="h-4 w-4 text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="min-w-0 flex-1 flex flex-col md:flex-row md:justify-between gap-2">
                                        <div class="flex flex-col gap-2">
                                            <div class="flex items-center gap-2 flex-wrap">
                                                <p class="font-bold text-[#e0bb35]">{{ $task->name }}</p>
                                                @if($task->is_hidden)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-gray-800 text-gray-400 border border-gray-700">
                                                        Hidden
                                                    </span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-gray-400 mt-1">
                                                PIC: <span class="text-gray-200">{{ $task->assigned->name ?? 'Unassigned' }}</span>
                                            </p>
                                            @if(Auth::user()->userRole->name === 'Admin')
                                                <a href="{{ route('projects.tasks.edit', [$task->management_project_id, $task->id]) }}" class="text-[10px] mt-2 uppercase tracking-wider bg-[#e0bb35] text-black font-bold py-2 px-2 rounded-md hover:bg-[#c9a72e] transition">
                                                    Update Status
                                                </a>
                                            @endif
                                        </div>
                                        <div class="flex items-center md:items-start justify-between md:justify-end gap-4">
                                            <time class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</time>
                                            <div class="h-6 w-6 rounded-full flex items-center justify-center shrink-0
                                                {{ $task->status->name == 'Finished' ? 'bg-green-500' : ($task->status->name == 'Cancelled' ? 'bg-red-500' : 'bg-blue-600') }}">
                                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h2 class="text-xl font-bold text-[#e0bb35] mb-6 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Update Progress
                </h2>
                <form action="{{ route('projects.progress.store', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#e0bb35] mb-1">Select Task</label>
                            <select name="task_id" class="w-full rounded bg-[#1a1a1a] border-gray-700 text-gray-300 px-3 py-2 text-sm">
                                <option value="">-- Choose Task --</option>
                                @foreach($project->tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#e0bb35] mb-1">Date</label>
                            <input type="date" name="progress_date" value="{{ date('Y-m-d') }}" class="w-full rounded bg-[#1a1a1a] border-gray-700 text-gray-300 px-3 py-2 text-sm [&::-webkit-calendar-picker-indicator]:invert">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#e0bb35] mb-1">Proof/Document (PDF, Image)</label>
                        <input type="file" name="document" required class="block w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-xs file:font-bold file:bg-[#e0bb35] file:text-black hover:file:bg-[#c9a72e]">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-[#e0bb35] mb-1">Work Notes</label>
                        <textarea name="notes" rows="2" class="w-full rounded bg-[#1a1a1a] border-gray-700 text-gray-300 px-3 py-2 text-sm" placeholder="What did you accomplish?"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-white text-black font-bold py-2.5 rounded hover:bg-gray-200 transition">
                        Submit Report
                    </button>
                </form>
            </div>

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h2 class="text-xl font-bold text-[#e0bb35] mb-6">Progress History</h2>
                <div class="space-y-6">
                    @foreach($project->progressLogs->sortByDesc('created_at') as $log)
                        <div class="flex gap-4 p-4 rounded-lg bg-[#1a1a1a] border border-gray-800 relative">
                            <div class="flex-1">
                                <div class="flex justify-between items-start flex-wrap gap-2 mb-2">
                                    <h4 class="text-sm font-bold text-gray-100">
                                        {{ $log->task->name ?? 'General Update' }}
                                    </h4>
                                    <span class="text-[10px] font-mono text-gray-500">{{ \Carbon\Carbon::parse($log->progress_date)->format('M d, Y') }}</span>
                                </div>
                                <p class="text-xs text-gray-400 italic mb-3">Report by {{ $log->user->name }}</p>
                                <p class="text-sm text-gray-300 leading-relaxed">{{ $log->notes }}</p>
                                <a href="{{ asset('storage/' . $log->document_path) }}" target="_blank" class="inline-flex items-center mt-4 text-[10px] font-bold text-[#e0bb35] uppercase hover:underline">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    View Document
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="space-y-8">

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#e0bb35] mb-4">Project Team</h3>
                <ul class="divide-y divide-gray-800">
                    @foreach($project->roleAssignments as $assignment)
                        <li class="py-3 flex items-center justify-between">
                            <div class="flex items-center overflow-hidden">
                                <div class="h-9 w-9 shrink-0 rounded-full bg-[#e0bb35] flex items-center justify-center text-black font-bold text-sm">
                                    {{ substr($assignment->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3 truncate">
                                    <p class="text-sm font-medium text-gray-100 truncate">{{ $assignment->user->name }}</p>
                                    <p class="text-xs text-gray-500 tracking-tighter">{{ $assignment->projectRole->name }}</p>
                                </div>
                            </div>
                            
                            @if(Auth::user()->userRole->name === 'Admin')
                                <form action="{{ route('projects.team.destroy', [$project->id, $assignment->id]) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-gray-600 hover:text-red-500 p-1 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if(Auth::user()->userRole->name === 'Admin')
                    <a href="{{ route('projects.team.create', $project->id) }}" class="mt-4 w-full block text-center border border-dashed border-gray-700 text-gray-400 py-2 rounded-md text-xs hover:border-[#e0bb35] hover:text-[#e0bb35] transition">
                        + Assign Member
                    </a>
                @endif
            </div>

            <div class="bg-[#0f0f0f] rounded-xl shadow-sm border border-gray-800 p-6">
                <h3 class="text-lg font-bold text-[#e0bb35] mb-4">Product Requirements</h3>
                <div class="space-y-4">
                    @forelse($project->productUsages as $usage)
                        @php
                            $shortage = $usage->quantity_needed - $usage->quantity;
                            $inventoryStock = $usage->inventoryItem->stock;
                        @endphp
                        <div class="bg-[#1a1a1a] p-3 rounded-md border border-gray-800">
                            <div class="flex justify-between items-start gap-2 mb-2">
                                <div class="overflow-hidden">
                                    <p class="text-sm font-bold text-gray-100 truncate">{{ $usage->inventoryItem->product->name }}</p>
                                    <p class="text-[10px] text-gray-400 mt-0.5">
                                        Req: {{ $usage->quantity_needed }} | Allocated: {{ $usage->quantity }}
                                    </p>
                                </div>
                                @if(Auth::user()->userRole->name === 'Admin')
                                    <form action="{{ route('projects.allocation.destroy', [$project->id, $usage->id]) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button class="text-gray-600 hover:text-red-500"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg></button>
                                    </form>
                                @endif
                            </div>

                            @if ($shortage > 0)
                                <div class="bg-red-500/10 border border-red-500/20 rounded p-2 mb-2">
                                    <p class="text-[10px] text-red-400 font-bold">Shortage: {{ $shortage }} units</p>
                                </div>

                                @if(Auth::user()->userRole->name === 'Admin')
                                    <form action="{{ route('projects.allocation.update', [$project->id, $usage->id]) }}" method="POST" class="flex flex-col gap-2">
                                        @csrf @method('PUT')
                                        @if($inventoryStock > 0)
                                            <div class="flex items-stretch gap-2">
                                                <input type="number" name="add_quantity" min="1" max="{{ min($shortage, $inventoryStock) }}" placeholder="Qty" 
                                                    class="w-full px-2 py-1 text-xs rounded bg-[#0f0f0f] border-gray-700 text-gray-300">
                                                <button type="submit" class="text-[10px] bg-[#e0bb35] text-black font-bold px-2 py-1 rounded">Supply</button>
                                            </div>
                                            <p class="text-[9px] text-gray-500 italic">Available in stock: {{ $inventoryStock }}</p>
                                        @else
                                            <p class="text-[10px] text-red-500 italic">Out of stock in warehouse</p>
                                        @endif
                                    </form>
                                @endif

                            @else
                                <span class="text-[10px] text-green-500 font-bold flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Fully Supplied
                                </span>
                            @endif
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 italic text-center py-4">No product requirements.</p>
                    @endforelse
                </div>
                @if(Auth::user()->userRole->name === 'Admin')
                    <a href="{{ route('projects.allocation.create', $project->id) }}" class="mt-4 w-full block text-center border border-dashed border-gray-700 text-gray-400 py-2 rounded-md text-xs hover:text-[#e0bb35] transition">
                        + Add Requirement
                    </a>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection