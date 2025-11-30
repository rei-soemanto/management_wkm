@extends('layout.mainlayout')

@section('name', 'Manage Clients')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    @if ($action === 'add' || $action === 'edit')
        <div class="max-w-3xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('clients.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to List
                </a>
                <h1 class="text-3xl font-bold text-[#e0bb35] mt-2">{{ $action === 'edit' ? 'Edit Client' : 'Add New Client' }}</h1>
            </div>

            <div class="bg-[#0f0f0f] shadow-lg rounded-xl overflow-hidden border border-gray-800">
                <form action="{{ $action === 'edit' ? route('clients.update', $client_to_edit->id) : route('clients.store') }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @if ($action === 'edit')
                        @method('PUT')
                    @endif

                    <div>
                        <label for="name" class="block text-sm font-bold text-[#e0bb35] mb-1">Company Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $client_to_edit->name ?? '') }}" required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 py-2 px-3">
                    </div>

                    <div>
                        <label for="pic_name" class="block text-sm font-bold text-[#e0bb35] mb-1">Person In Charge (PIC)</label>
                        <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name', $client_to_edit->pic_name ?? '') }}" required 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 py-2 px-3">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-bold text-[#e0bb35] mb-1">Contact Email</label>
                        <input type="text" name="email" id="email" value="{{ old('email', $client_to_edit->email ?? '') }}" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 py-2 px-3">
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-bold text-[#e0bb35] mb-1">Contact Phone</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $client_to_edit->phone ?? '') }}" 
                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 py-2 px-3">
                    </div>

                    <div class="pt-4 border-t border-[#e0bb35] flex justify-end gap-3">
                        <a href="{{ route('clients.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-[#e0bb35] border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-[#e3cf85]">
                            {{ $action === 'edit' ? 'Update Client' : 'Save Client' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

    @else
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-[#e0bb35]">Clients</h1>
            <a href="{{ route('clients.create') }}" class="bg-[#e0bb35] hover:bg-[#e3cf85] text-black font-bold py-2 px-4 rounded shadow transition flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Add Client
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-md">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-[#0f0f0f] shadow overflow-hidden sm:rounded-lg border border-gray-800">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-[#0f0f0f]">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Company Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">PIC / Contact</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Active Projects</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-[#0f0f0f] divide-y divide-gray-800">
                    @forelse($clients as $client)
                    <tr class="hover:bg-black">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-[#e0bb35]">{{ $client->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-[#e0bb35]">{{ $client->pic_name }}</div>
                            @if ($client->email)
                                <div class="text-sm text-gray-300">{{ $client->email }}</div>
                            @else
                                <span class="text-sm text-gray-300">None</span>
                            @endif
                            @if ($client->phone)
                                <div class="text-sm text-gray-300">{{ $client->phone }}</div>
                            @else
                                <span class="text-sm text-gray-300">None</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-[#0f0f0f]">
                                {{ $client->management_projects_count }} Projects
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('clients.edit', $client->id) }}" class="text-[#e0bb35] hover:text-[#e3cf85] mr-4 font-bold">Edit</a>
                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-400 font-bold">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">No clients found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection