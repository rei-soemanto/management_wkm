@extends('layout.mainlayout')

@section('name', $project->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- ===========================
            1. HEADER SECTION
    =========================== --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2.5 py-0.5 rounded">
                        {{ $project->client->name }}
                    </span>
                    <span class="text-gray-400 text-sm">|</span>
                    <span class="text-gray-500 text-sm">Due: {{ \Carbon\Carbon::parse($project->due_date)->format('M d, Y') }}</span>
                </div>
                <div class="flex items-center gap-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $project->name }}</h1>
                    @if(Auth::user()->userRole->name === 'Admin')
                        <a href="{{ route('projects.edit', $project->id) }}" class="text-sm text-blue-600 hover:underline font-bold">Edit Project</a>
                    @endif
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <div class="text-right mr-2">
                    <p class="text-xs text-gray-500 uppercase tracking-wide">Current Status</p>
                    <p class="text-lg font-bold text-gray-900">{{ $project->status->name }}</p>
                </div>
                {{-- Visual Status Indicator --}}
                <div class="h-10 w-10 rounded-full flex items-center justify-center 
                    {{ $project->status->name == 'Finished' ? 'bg-green-500' : ($project->status->name == 'Cancelled' ? 'bg-red-500' : 'bg-blue-500') }}">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
        <p class="text-gray-600 mt-4 border-t border-gray-100 pt-4">
            {{ $project->description }}
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- ===========================
            2. LEFT COLUMN (Progress)
        =========================== --}}
        <div class="lg:col-span-2 space-y-8">
            
            {{-- ACTION: REPORT PROGRESS --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Update Progress
                </h2>
                <form action="{{ route('projects.progress.store', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">New Status</label>
                            <select name="status_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                @foreach(App\Models\Managements\Status::all() as $status)
                                    <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date</label>
                            <input type="date" name="progress_date" value="{{ date('Y-m-d') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Report Document (Required)</label>
                        <input type="file" name="document" required class="mt-1 block w-full text-sm text-gray-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-full file:border-0
                            file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700
                            hover:file:bg-blue-100">
                        <p class="text-xs text-gray-500 mt-1">PDF, DOCX, or Image proofs.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea name="notes" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Brief description of work done..."></textarea>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-2 px-4 rounded-md hover:bg-blue-700 transition">
                        Submit Report & Update Status
                    </button>
                </form>
            </div>

            {{-- HISTORY TIMELINE --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Progress History</h2>
                <div class="flow-root">
                    <ul role="list" class="-mb-8">
                        @foreach($project->progressLogs->sortByDesc('created_at') as $log)
                            <li>
                                <div class="relative pb-8">
                                    @if(!$loop->last)
                                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                    @endif
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-gray-400 flex items-center justify-center ring-8 ring-white">
                                                <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-sm text-gray-500">
                                                    Updated to <span class="font-medium text-gray-900">{{ $log->status->name }}</span> by <span class="font-medium text-gray-900">{{ $log->user->name }}</span>
                                                </p>
                                                <p class="text-sm text-gray-700 mt-1">{{ $log->notes }}</p>
                                                <a href="{{ asset('storage/' . $log->document_path) }}" target="_blank" class="inline-flex items-center mt-2 px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50">
                                                    View Document
                                                </a>
                                            </div>
                                            <div class="text-right text-sm whitespace-nowrap text-gray-500">
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

        {{-- ===========================
            3. RIGHT COLUMN (Team & BOM)
        =========================== --}}
        <div class="space-y-8">

            {{-- TEAM MEMBERS --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Project Team</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach($project->roleAssignments as $assignment)
                        <li class="py-3 flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                    {{ substr($assignment->user->name, 0, 1) }}
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">{{ $assignment->user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $assignment->projectRole->name }}</p>
                                </div>
                            </div>
                            
                            {{-- Remove Button (Admin Only) --}}
                            @if(Auth::user()->userRole->name === 'Admin')
                                <form action="{{ route('projects.team.destroy', [$project->id, $assignment->id]) }}" method="POST" onsubmit="return confirm('Remove this member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Remove Member">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            @endif
                        </li>
                    @endforeach
                </ul>
                @if(Auth::user()->userRole->name === 'Admin')
                    {{-- FIXED: Now links to the real controller --}}
                    <a href="{{ route('projects.team.create', $project->id) }}" class="mt-4 w-full block text-center border border-dashed border-gray-300 text-gray-600 py-2 rounded-md text-sm hover:bg-gray-50 hover:text-blue-600 transition">
                        + Assign Member (Admin)
                    </a>
                @endif
            </div>

            {{-- ALLOCATED INVENTORY (BOM) --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Allocated Products</h3>
                <ul class="space-y-3">
                    @forelse($project->productUsages as $usage)
                        <li class="flex justify-between items-center bg-gray-50 p-3 rounded-md group">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $usage->inventoryItem->product->name }}</p>
                                <p class="text-xs text-gray-500">Qty: <span class="font-bold">{{ $usage->quantity }}</span></p>
                            </div>
                            <div class="flex items-center gap-2">
                                {{-- Remove Button (Admin Only) --}}
                                @if(Auth::user()->userRole->name === 'Admin')
                                    <form action="{{ route('projects.allocation.destroy', [$project->id, $usage->id]) }}" method="POST" onsubmit="return confirm('Remove item? Stock will be returned.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 p-1" title="Remove & Return Stock">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </li>
                    @empty
                        <p class="text-sm text-gray-500 italic text-center py-4">No products allocated yet.</p>
                    @endforelse
                </ul>
                @if(Auth::user()->userRole->name === 'Admin')
                    {{-- FIXED: Now links to the real controller --}}
                    <a href="{{ route('projects.allocation.create', $project->id) }}" class="mt-4 w-full block text-center border border-dashed border-gray-300 text-gray-600 py-2 rounded-md text-sm hover:bg-gray-50 hover:text-blue-600 transition">
                        + Allocate Product (Admin)
                    </a>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection