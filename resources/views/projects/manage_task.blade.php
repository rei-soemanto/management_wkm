@extends('layout.mainlayout')

@section('name', 'Manage Task')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 md:py-10">
    
    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
        <h2 class="text-xl md:text-2xl text-[#e0bb35] font-bold">Manage Task</h2>
        <a href="{{ route('projects.show', $project->id) }}" class="text-gray-400 hover:text-white text-sm flex items-center transition">
            <span class="mr-1">&larr;</span> Back to Project
        </a>
    </div>

    <div class="bg-[#0f0f0f] shadow-lg rounded-xl p-5 md:p-8 border border-gray-800">
        <p class="text-gray-400 text-sm mb-6 pb-4 border-b border-gray-800">
            Editing Task: <strong class="text-white font-bold">{{ $task->name }}</strong>
        </p>

        <form action="{{ route('projects.tasks.update', [$project->id, $task->id]) }}" method="POST" class="space-y-5">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-sm font-bold text-[#e0bb35] mb-2 uppercase tracking-wide">Task Name</label>
                <input type="text" name="name" value="{{ old('name', $task->name) }}" required 
                    class="w-full rounded-md bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] px-4 py-3 text-sm outline-none transition">
            </div>

            <div>
                <label class="block text-sm font-bold text-[#e0bb35] mb-2 uppercase tracking-wide">Description</label>
                <textarea name="description" rows="3" 
                    class="w-full rounded-md bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] px-4 py-3 text-sm outline-none transition">{{ old('description', $task->description) }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-[#e0bb35] mb-2 uppercase tracking-wide">Assign To (PIC)</label>
                    <select name="assigned_to" required 
                        class="w-full rounded-md bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] pl-4 pr-12 py-3 text-sm outline-none cursor-pointer appearance-none bg-no-repeat bg-position-[right_1.25rem_center] bg-size-[1rem]"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-width%3D%223%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E');">
                        @foreach($project->roleAssignments as $assignment)
                            <option value="{{ $assignment->user->id }}">{{ $assignment->user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#e0bb35] mb-2 uppercase tracking-wide">Status</label>
                    <select name="status_id" 
                        class="w-full rounded-md bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] pl-4 pr-12 py-3 text-sm outline-none cursor-pointer appearance-none bg-no-repeat bg-position-[right_1.25rem_center] bg-size-[1rem]"
                        style="background-image: url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22%23ffffff%22%20stroke-width%3D%223%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%3E%3Cpolyline%20points%3D%226%209%2012%2015%2018%209%22%3E%3C%2Fpolyline%3E%3C%2Fsvg%3E');">
                        @foreach($statuses as $status)
                            <option value="{{ $status->id }}"> {{ $status->name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-[#e0bb35] mb-2 uppercase tracking-wide">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}" 
                    class="w-full rounded-md bg-[#1a1a1a] border-gray-700 text-white focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] px-4 py-3 text-sm outline-none transition
                    [&::-webkit-calendar-picker-indicator]:invert">
            </div>

            <div class="flex items-center p-3 bg-[#1a1a1a]/50 rounded-lg border border-gray-800">
                <input id="is_hidden" name="is_hidden" type="checkbox" value="1" 
                    {{ old('is_hidden', $task->is_hidden) ? 'checked' : '' }}
                    class="h-5 w-5 rounded border-gray-600 bg-[#0f0f0f] text-[#e0bb35] focus:ring-[#e0bb35] cursor-pointer">
                <label for="is_hidden" class="ml-3 block text-sm text-gray-300 cursor-pointer">
                    Mark as <span class="text-[#e0bb35] font-bold">Hidden Task</span> (Internal only)
                </label>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-between items-center pt-6 gap-4 border-t border-gray-800">
                <div class="flex w-full sm:w-auto gap-3">
                    <a href="{{ route('projects.show', $project->id) }}" 
                        class="flex-1 flex items-center justify-center sm:flex-none text-center px-6 py-3 border border-gray-700 rounded-md text-gray-400 hover:text-white hover:border-white transition text-sm font-bold">
                        Cancel
                    </a>
                    <button type="submit" 
                        class="flex-1 sm:flex-none px-8 py-3 bg-[#e0bb35] text-black rounded-md font-bold hover:bg-[#c9a72e] transition active:scale-95 text-sm">
                        Update Task
                    </button>
                </div>
            </div>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-800 flex justify-center sm:justify-end">
            <form action="{{ route('projects.tasks.destroy', [$project->id, $task->id]) }}" method="POST" 
                onsubmit="return confirm('Are you sure you want to delete this task?');" class="w-full sm:w-auto">
                @csrf 
                @method('DELETE')
                <button type="submit" class="w-full sm:w-auto text-red-500 hover:text-red-400 text-xs font-bold uppercase tracking-widest flex items-center justify-center gap-2 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Delete Task
                </button>
            </form>
        </div>

    </div>
</div>
@endsection