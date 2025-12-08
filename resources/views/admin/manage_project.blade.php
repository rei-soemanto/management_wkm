@extends('layout.mainlayout')

@section('name', 'Manage Projects')
@section('content')
<main class="min-h-[597px] bg-cover bg-center relative" style="background-image: url('{{ asset('img/aboutpagebg.jpg') }}')">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        @if ($action === 'add' || $action === 'edit')
            
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 drop-shadow-sm">
                    {{ $action === 'edit' ? 'Edit' : 'Add New' }} Project
                </h1>
                
                <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
                    <div class="p-8">
                        <form id="projectForm" action="{{ $action === 'edit' ? route('admin.projects.update', $project_to_edit->id) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($action === 'edit')
                                @method('PUT')
                            @endif

                            <input type="hidden" name="project_id" value="{{ $project_to_edit['project_id'] ?? '' }}">
                            
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Project Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $project_to_edit->name ?? '') }}" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-700 focus:ring-purple-700 sm:text-sm px-4 py-2" required>
                            </div>
                            
                            <div class="mb-6">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Categories (Max 4)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    @foreach ($categories as $category)
                                    <div class="flex items-center">
                                        <input type="checkbox" id="category_{{ $category->id }}" name="category_ids[]" value="{{ $category->id }}"
                                            class="h-4 w-4 text-purple-700 focus:ring-purple-700 border-gray-300 rounded"
                                            @checked(in_array($category->id, $project_categories_assigned ?? []))>
                                        <label for="category_{{ $category->id }}" class="ml-2 block text-sm text-gray-900">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                <textarea id="description" name="description" rows="5" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-purple-700 focus:ring-purple-700 sm:text-sm px-4 py-2">{{ old('description', $project_to_edit->description ?? '') }}</textarea>
                            </div>

                            <div class="mb-6">
                                <label for="images" class="block text-sm font-bold text-gray-700 mb-2">Add New Images</label>
                                <input type="file" id="images" name="images[]" multiple 
                                    class="block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-full file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-purple-700 file:text-white
                                    hover:file:bg-purple-800">
                            </div>

                            @if (!empty($project_images))
                            <div class="mb-8">
                                <label class="block text-sm font-bold text-gray-700 mb-2">Current Images (Check to delete)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($project_images as $image)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Current Image" class="w-full h-32 object-cover rounded-lg shadow-sm">
                                        <div class="absolute top-2 right-2">
                                            <input type="checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_img_{{ $image->id }}"
                                                class="h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded bg-white">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all">
                                    {{ $action === 'edit' ? 'Update' : 'Save' }} Project
                                </button>
                                <a href="{{ route('admin.projects.list') }}" class="text-gray-600 hover:text-gray-800 font-medium underline">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            @else
                
                <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                    <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-sm">Manage Projects</h1>
                    <a href="{{ route('admin.projects.create') }}" class="md:mt-0 bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all">
                        Add New Project
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
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider w-32">Image</th>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Project Name</th>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Categories</th>
                                    <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden md:table-cell">Last Updated</th>
                                    <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($projects as $project)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($project->thumbnail)
                                                <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="Thumbnail" class="h-16 w-24 object-cover rounded shadow-sm">
                                            @else
                                                <div class="h-16 w-24 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Img</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $project->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $project->category_names ?? 'N/A' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                            <span class="block">{{ $project->lastUpdatedBy->name ?? 'N/A' }}</span>
                                            <span class="text-xs">{{ $project->updated_at->format('M j, Y, g:i a') }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('admin.projects.edit', $project->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 py-1 px-3 rounded font-bold shadow-sm transition-colors">Edit</a>
                                                <form action="{{ route('admin.projects.destroy', $project->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded font-bold shadow-sm transition-colors" onclick="return confirm('Are you sure you want to delete this project?');">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No projects found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('projectForm');
        if (form) {
            const checkboxes = form.querySelectorAll('input[name="category_ids[]"]');
            const max = 4;
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', () => {
                    const checkedCount = Array.from(checkboxes).filter(i => i.checked).length;
                    if (checkedCount > max) {
                        alert('You can select a maximum of ' + max + ' categories.');
                        checkbox.checked = false;
                    }
                });
            });
        }
    });
</script>
@endpush