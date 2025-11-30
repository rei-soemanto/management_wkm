@extends('layout.mainlayout')
@section('name', 'Manage Task')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-[#0f0f0f] shadow rounded-lg p-6">
        <h2 class="text-xl text-[#e0bb35] font-bold mb-4">Manage Task</h2>
        <p class="text-gray-300 mb-6">Task: <strong>{{ $task->name }}</strong></p>

        <form action="{{ route('projects.team.store', $task->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <p class="text-sm text-gray-300">
                    Assigned to <span class="font-medium text-[#e0bb35]">{{ $task->user->name }}</span>
                </p>
                <div class="text-right text-sm whitespace-nowrap text-gray-300">
                    <time datetime="{{ $task->due_date }}">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</time>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#e0bb35]">Task Status</label>
                <select name="status_id" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                    @foreach(App\Models\Managements\Status::all() as $status)
                        <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : '' }}>
                            {{ $status->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#e0bb35] text-black rounded-md hover:bg-[#e3cf85]">Update</button>
                <form action="{{ route('projects.tasks.destroy', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-400 font-bold">Delete</button>
                </form>
            </div>
        </form>
    </div>
</div>
@endsection