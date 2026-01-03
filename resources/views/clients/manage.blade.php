@extends('layout.mainlayout')

@section('name', 'Manage Clients')

@section('content')
<main class="min-h-[597px] bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        @if ($action === 'add' || $action === 'edit')
            {{-- FORM VIEW --}}
            <div class="max-w-2xl mx-auto">
                <div class="mb-8">
                    <a href="{{ route('clients.index') }}" class="text-sm text-white hover:text-[#e0bb35] flex items-center transition-colors font-bold uppercase">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to List
                    </a>
                    <h1 class="text-3xl font-bold text-[#e0bb35] mt-2 uppercase tracking-tight">
                        {{ $action === 'edit' ? 'Edit Client Profile' : 'Register New Client' }}
                    </h1>
                </div>

                <div class="bg-[#0f0f0f] shadow-2xl rounded-xl overflow-hidden border border-gray-700 p-8">
                    <form action="{{ $action === 'edit' ? route('clients.update', $client_to_edit->id) : route('clients.store') }}" method="POST" class="space-y-6">
                        @csrf
                        @if ($action === 'edit') @method('PUT') @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="name" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Company Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $client_to_edit->name ?? '') }}" required 
                                    class="block w-full bg-black border border-gray-700 rounded-md text-white py-2.5 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none transition-all">
                            </div>

                            <div>
                                <label for="pic_name" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Person In Charge (PIC)</label>
                                <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name', $client_to_edit->pic_name ?? '') }}" required 
                                    class="block w-full bg-black border border-gray-700 rounded-md text-white py-2.5 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none">
                            </div>

                            <div>
                                <label for="email" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Contact Email</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $client_to_edit->email ?? '') }}" 
                                    class="block w-full bg-black border border-gray-700 rounded-md text-white py-2.5 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none">
                            </div>

                            <div class="md:col-span-2">
                                <label for="phone" class="block text-xs font-bold text-[#e0bb35] mb-2 uppercase tracking-widest">Contact Phone</label>
                                <input type="text" name="phone" id="phone" value="{{ old('phone', $client_to_edit->phone ?? '') }}" 
                                    class="block w-full bg-black border border-gray-700 rounded-md text-white py-2.5 px-4 focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] outline-none">
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-800 flex justify-end gap-3">
                            <a href="{{ route('clients.index') }}" class="px-6 py-2 bg-white text-black rounded-md font-bold text-xs uppercase hover:bg-gray-200 transition-colors">Cancel</a>
                            <button type="submit" class="px-6 py-2 bg-[#e0bb35] rounded-md font-bold text-xs text-black uppercase hover:bg-[#f2cc4a] transition-colors shadow-lg">
                                {{ $action === 'edit' ? 'Update Client' : 'Save Client' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        @else
            {{-- LIST VIEW --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-[#e0bb35] tracking-tight">Client Directory</h1>
                    <p class="text-white mt-1">Manage corporate partnerships and project links.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 w-full md:max-w-2xl">
                    <form action="{{ route('clients.index') }}" method="GET" class="w-full">
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search company, PIC, or contact info..." 
                                class="w-full bg-[#0f0f0f] text-white border border-gray-700 rounded-lg py-2.5 px-4 pl-10 focus:ring-2 focus:ring-[#e0bb35] outline-none">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                    </form>

                    <a href="{{ route('clients.create') }}" class="whitespace-nowrap bg-[#e0bb35] hover:bg-[#f2cc4a] text-black font-bold py-2.5 px-6 rounded-lg shadow-lg transition flex items-center uppercase text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Add Client
                    </a>
                </div>
            </div>

            {{-- Notifications --}}
            @if (session('success'))
                <div class="bg-green-900/30 border-l-4 border-green-500 text-white p-4 mb-6 rounded shadow-lg backdrop-blur-sm">
                    <span class="font-bold">Success:</span> {{ session('success') }}
                </div>
            @endif

            <div class="bg-[#0f0f0f] rounded-xl shadow-2xl overflow-hidden border border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-800">
                        <thead class="bg-black">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest">Company</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest hidden md:table-cell">Primary Contact</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Projects</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($clients as $client)
                                <tr class="hover:bg-white/5 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-[#e0bb35]">{{ $client->name }}</div>
                                        <div class="text-[10px] text-white/60 md:hidden mt-1">{{ $client->pic_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <div class="text-sm text-white font-medium">{{ $client->pic_name }}</div>
                                        <div class="text-xs text-gray-400">{{ $client->email ?? 'No Email' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="inline-flex items-center justify-center w-10 h-10 text-[#e0bb35] font-bold text-xs">
                                            {{ $client->management_projects_count }}
                                        </div>
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex items-center justify-center gap-2">
                                            {{-- EDIT BUTTON --}}
                                            <a href="{{ route('clients.edit', $client->id) }}" 
                                            class="bg-[#e0bb35] hover:bg-[#f2cc4a] text-black text-[10px] font-bold py-1.5 px-3 rounded uppercase transition-all shadow-md">
                                                Edit
                                            </a>

                                            {{-- DETAILS BUTTON (Full Schema) --}}
                                            <button type="button" 
                                                class="sidebar-details-trigger bg-gray-800 hover:bg-gray-700 text-white text-[10px] font-bold py-1.5 px-3 rounded uppercase border border-gray-600 transition-all"
                                                data-sidebar-title="Client Profile"
                                                data-sidebar-schema="{{ json_encode([
                                                    ['type' => 'header', 'label' => 'Company Name', 'value' => $client->name],
                                                    ['type' => 'grid', 'items' => [
                                                        ['label' => 'PIC Name', 'value' => $client->pic_name],
                                                        ['label' => 'Active Projects', 'value' => (string)$client->management_projects_count],
                                                        ['label' => 'Phone Number', 'value' => $client->phone ?? 'Not Listed'],
                                                        ['label' => 'Email Address', 'value' => $client->email ?? 'Not Listed']
                                                    ]]
                                                ]) }}">
                                                Details
                                            </button>

                                            {{-- DELETE BUTTON --}}
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" class="inline" onsubmit="return confirm('Archive this client?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white text-[10px] font-bold py-1.5 px-3 rounded uppercase transition-all shadow-md">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center text-gray-500 uppercase tracking-widest opacity-50">
                                        No client records found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8">
                <style>
                    nav[role="navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between div:first-child p { color: #9ca3af !important; }
                    nav[role="navigation"] span[aria-current="page"] span { background-color: #e0bb35 !important; color: black !important; border-color: #e0bb35 !important; font-weight: bold; }
                    nav[role="navigation"] a { background-color: #0f0f0f !important; color: white !important; border-color: #374151 !important; transition: all 0.2s; }
                    nav[role="navigation"] a:hover { border-color: #e0bb35 !important; color: #e0bb35 !important; }
                </style>
                {{ $clients->withQueryString()->links() }}
            </div>
        @endif
    </div>
</main>
@endsection