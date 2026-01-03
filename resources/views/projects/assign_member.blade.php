@extends('layout.mainlayout')
@section('name', 'Assign Member')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 md:py-12">
    <div class="bg-[#0f0f0f] shadow-xl rounded-xl border border-gray-800 p-5 md:p-8">
        <h2 class="text-xl md:text-2xl text-[#e0bb35] font-bold mb-2">Assign Team Member</h2>
        <p class="text-sm text-gray-400 mb-6">
            Project: <span class="text-gray-100 font-bold">{{ $project->name }}</span>
        </p>

        <form action="{{ route('projects.team.store', $project->id) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-sm font-bold text-[#e0bb35]">Search & Select Employee</label>
                
                <input type="text" id="employeeSearch" placeholder="Type name or email to filter..." 
                    class="block w-full rounded-md bg-[#1a1a1a] border-gray-600 text-gray-200 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm px-4 py-3 outline-none transition mb-2">
                
                <select name="user_id" id="employeeSelect" required 
                    class="block w-full rounded-md bg-[#0f0f0f] border-gray-600 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm text-gray-300 px-3 py-3 outline-none transition cursor-pointer">
                    <option value="">-- Choose an Employee --</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" data-search="{{ strtolower($user->name . ' ' . $user->email) }}">
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                <p class="text-[11px] text-gray-500 italic">The list updates automatically as you type.</p>
            </div>

            <div class="space-y-2">
                <label class="block text-sm font-bold text-[#e0bb35]">Project Role</label>
                <select name="role_id" required 
                    class="block w-full rounded-md bg-[#1a1a1a] border-gray-700 text-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm px-4 py-3 outline-none transition cursor-pointer">
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-gray-800">
                <a href="{{ route('projects.show', $project->id) }}" 
                    class="flex items-center justify-center px-6 py-3 text-sm font-bold text-gray-400 hover:text-white transition">
                    Cancel
                </a>
                <button type="submit" 
                    class="flex items-center justify-center px-8 py-3 bg-[#e0bb35] text-black font-bold rounded-md hover:bg-[#c9a72e] transition shadow-lg active:scale-95">
                    Assign to Project
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('employeeSearch');
        const selectDropdown = document.getElementById('employeeSelect');
        
        // Clone the original options into an array to maintain the full list for filtering
        const originalOptions = Array.from(selectDropdown.options);

        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            
            // Clear current options
            selectDropdown.innerHTML = '';

            // Filter the original set
            const matchingOptions = originalOptions.filter(option => {
                // Always include the "Choose an Employee" placeholder if the filter is empty
                if (option.value === "" && filter === "") return true;
                
                const text = option.getAttribute('data-search');
                return text && text.includes(filter);
            });

            // Re-append only matches
            matchingOptions.forEach(option => selectDropdown.appendChild(option));
            
            // Auto-select the first available match if something was found
            if (matchingOptions.length > 0) {
                // If there's a placeholder, and we are searching, don't auto-select the placeholder
                if (matchingOptions.length > 1 && matchingOptions[0].value === "") {
                    selectDropdown.value = matchingOptions[1].value;
                } else {
                    selectDropdown.value = matchingOptions[0].value;
                }
            }
        });
    });
</script>
@endsection