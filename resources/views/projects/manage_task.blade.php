@extends('layout.mainlayout')

@section('name', 'Manage Task')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    
    {{-- Header --}}
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-xl text-[#e0bb35] font-bold">Manage Task</h2>
        <a href="{{ route('projects.show', $project->id) }}" class="text-gray-400 hover:text-white text-sm">
            &larr; Back to Project
        </a>
    </div>

    <div class="bg-[#0f0f0f] shadow-lg rounded-lg p-6 border border-gray-800">
        <p class="text-gray-400 text-sm mb-6">Editing Task: <strong class="text-white">{{ $task->name }}</strong></p>

        <form action="{{ route('projects.tasks.update', [$project->id, $task->id]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-medium text-[#e0bb35] mb-1">Assign To (PIC)</label>
                <select name="assigned_to" required class="w-full rounded bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-[#e0bb35] px-3 py-2">
                    @foreach($project->roleAssignments as $assignment)
                        <option value="{{ $assignment->user->id }}" {{ $task->assigned_to == $assignment->user->id ? 'selected' : '' }}>
                            {{ $assignment->user->name }} ({{ $assignment->projectRole->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#e0bb35] mb-1">Status</label>
                <select name="status" class="w-full rounded bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-[#e0bb35] px-3 py-2">
                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="On Hold" {{ $task->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-[#e0bb35] mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" 
                    class="w-full rounded bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-[#e0bb35] px-3 py-2">
            </div>

            <div class="flex justify-between pt-6 border-t border-gray-800">
                <div class="flex gap-3">
                    <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 border border-gray-600 rounded text-gray-400 hover:text-white hover:border-white transition">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-[#e0bb35] text-black rounded font-bold hover:bg-[#e3cf85] transition">Update Task</button>
                </div>
            </div>
        </form>

        <div class="mt-4 flex justify-end">
            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                @csrf 
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-bold underline decoration-red-500/30 hover:decoration-red-400">
                    Delete Task
                </button>
            </form>
        </div>

    </div>
</div>
@endsection