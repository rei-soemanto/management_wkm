@extends('layout.mainlayout')
@section('name', 'Assign Member')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-[#0f0f0f] shadow rounded-lg p-6">
        <h2 class="text-xl text-[#e0bb35] font-bold mb-4">Assign Team Member</h2>
        <p class="text-gray-300 mb-6">Project: <strong>{{ $project->name }}</strong></p>

        <form action="{{ route('projects.team.store', $project->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <input type="text" id="employeeSearch" placeholder="Type name or email to filter..." 
                class="block w-full rounded-md bg-[#1a1a1a] border-gray-600 text-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2 mb-2">

                <label class="block text-sm font-medium text-[#e0bb35]">Select Employee</label>
                <select name="user_id" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                    <option value="">-- Choose Employee --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                </select>

                <script>
                    document.getElementById('employeeSearch').addEventListener('input', function() {
                        let filter = this.value.toLowerCase();
                        let select = document.getElementById('employeeSelect');
                        let options = select.getElementsByTagName('option');
                        let firstVisible = null;

                        for (let i = 0; i < options.length; i++) {
                            let option = options[i];
                            if (option.value === "") continue;

                            let text = option.getAttribute('data-search');
                            
                            if (text.indexOf(filter) > -1) {
                                option.style.display = "";
                                if (!firstVisible) firstVisible = option;
                            } else {
                                option.style.display = "none";
                            }
                        }
                        
                        if (select.selectedOptions[0].style.display === "none" && firstVisible) {
                            select.value = firstVisible.value;
                        }
                    });
                </script>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#e0bb35]">Project Role</label>
                <select name="role_id" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#e0bb35] text-black rounded-md hover:bg-[#e3cf85]">Assign</button>
            </div>
        </form>
    </div>
</div>
@endsection