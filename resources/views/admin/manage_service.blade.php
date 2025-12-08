@extends('layout.mainlayout')

@section('name', 'Manage Services')
@section('content')
<main class="min-h-[597px] bg-cover bg-center relative" style="background-image: url('{{ asset('img/aboutpagebg.jpg') }}')">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        @if ($action === 'add' || $action === 'edit')

            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 drop-shadow-sm">
                    {{ $action === 'edit' ? 'Edit' : 'Add New' }} Service
                </h1>
                
                <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
                    <div class="p-8">
                        <form action="{{ $action === 'edit' ? route('admin.services.update', $service_to_edit->id) : route('admin.services.store') }}" method="POST">
                            @csrf
                            @if ($action === 'edit')
                                @method('PUT')
                            @endif

                            <input type="hidden" name="service_id" value="{{ $service_to_edit['service_id'] ?? '' }}">

                            <div class="mb-6">
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Service Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $service_to_edit->name ?? '') }}" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 sm:text-sm px-4 py-2" required>
                            </div>
                            
                            <div class="mb-6">
                                <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                <select id="category_id" name="category_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700 sm:text-sm px-4 py-2" required>
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            @selected(old('category_id', $service_to_edit->category_id ?? '') == $category->id)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-6">
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                <textarea id="description" name="description" rows="5" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-green-700 focus:ring-green-700 sm:text-sm px-4 py-2">{{ old('description', $service_to_edit['description'] ?? '') }}</textarea>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all">
                                    {{ $action === 'edit' ? 'Update' : 'Save' }} Service
                                </button>
                                <a href="{{ route('admin.services.list') }}" class="text-gray-600 hover:text-gray-800 font-medium underline">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @else
        
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-sm">Manage Services</h1>

                <form action="{{ route('admin.services.list') }}" method="GET" class="flex-1 w-full md:max-w-md mx-4">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}" 
                            placeholder="Search services or categories..." 
                            class="w-full bg-white/90 text-gray-800 border-none rounded-lg py-2 px-4 pl-10 focus:ring-2 focus:ring-green-500 shadow-lg"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        @if(request('search'))
                            <a href="{{ route('admin.services.list') }}" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-red-500">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </form>

                <a href="{{ route('admin.services.create') }}" class="md:mt-0 bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all">
                    Add New Service
                </a>
            </div>

            @if (session('message'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md" role="alert">
                    <p>{{ session('message') }}</p>
                </div>
            @endif

            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-800 text-white">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Service Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden md:table-cell">Last Updated</th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($services as $service)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $service->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $service->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        <span class="block">{{ $service->lastUpdatedBy->name ?? 'N/A' }}</span>
                                        <span class="text-xs">{{ $service->updated_at->format('M j, Y, g:i a') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('admin.services.edit', $service->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 py-1 px-3 rounded font-bold shadow-sm transition-colors">Edit</a>
                                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded font-bold shadow-sm transition-colors" onclick="return confirm('Are you sure you want to delete this service?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">No services found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
                {{-- ... Table Content ... --}}
            </div>

            <div class="mt-4">
                {{ $services->withQueryString()->links() }}
            </div>
        @endif
    </div>
</main>
@endsection