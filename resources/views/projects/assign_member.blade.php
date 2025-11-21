@extends('layout.mainlayout')
@section('name', 'Assign Member')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-bold mb-4">Assign Team Member</h2>
        <p class="text-gray-600 mb-6">Project: <strong>{{ $project->name }}</strong></p>

        <form action="{{ route('projects.team.store', $project->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Select Employee</label>
                <select name="user_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Project Role</label>
                <select name="role_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-gray-600">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Assign</button>
            </div>
        </form>
    </div>
</div>
@endsection