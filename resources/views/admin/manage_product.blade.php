@extends('layout.mainlayout')

@section('name', 'Manage Products')
@section('content')
<main class="min-h-[597px] bg-cover bg-center relative" style="background-image: url('{{ asset('img/aboutpagebg.jpg') }}')">
    <div class="absolute inset-0 bg-black/50"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        @if ($action === 'add' || $action === 'edit')
            
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white mb-6 drop-shadow-sm">
                    {{ $action === 'edit' ? 'Edit' : 'Add New' }} Product
                </h1>
                
                <div class="bg-white/95 backdrop-blur-md rounded-xl shadow-2xl overflow-hidden">
                    <div class="p-8">
                        <form action="{{ $action === 'edit' ? route('admin.products.update', $product_to_edit->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @if ($action === 'edit')
                                @method('PUT')
                            @endif

                            <input type="hidden" name="product_id" value="{{ $product_to_edit['product_id'] ?? '' }}">
                            
                            <div class="mb-6">
                                <label for="name" class="block text-sm font-bold text-gray-700 mb-2">Product Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $product_to_edit->name ?? '') }}" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-700 focus:ring-blue-700 sm:text-sm px-4 py-2" required>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="brand_id" class="block text-sm font-bold text-gray-700 mb-2">Brand</label>
                                    <select id="brand_id" name="brand_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-700 focus:ring-blue-700 sm:text-sm px-4 py-2" required>
                                        <option value="">Select a brand</option>
                                        @foreach ($brands as $brand) 
                                            <option value="{{ $brand->id }}" 
                                                @selected(old('brand_id', $product_to_edit->brand_id ?? '') == $brand->id)>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                                    <select id="category_id" name="category_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-700 focus:ring-blue-700 sm:text-sm px-4 py-2" required>
                                        <option value="">Select a category</option>
                                        @foreach ($categories as $category) 
                                            <option value="{{ $category->id }}" 
                                                @selected(old('category_id', $product_to_edit->category_id ?? '') == $category->id)>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                                <textarea id="description" name="description" rows="5" 
                                    class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-700 focus:ring-blue-700 sm:text-sm px-4 py-2">{{ old('description', $product_to_edit['description'] ?? '') }}</textarea>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                                <div>
                                    <label for="image" class="block text-sm font-bold text-gray-700 mb-2">Product Image</label>
                                    <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-700 file:text-white
                                        hover:file:bg-blue-800">
                                    @if (!empty($product_to_edit['image']))
                                        <p class="mt-2 text-xs text-gray-500">Current: {{ basename($product_to_edit->image) }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label for="product_pdf" class="block text-sm font-bold text-gray-700 mb-2">Product PDF</label>
                                    <input type="file" id="product_pdf" name="pdf_path" class="block w-full text-sm text-gray-500
                                        file:mr-4 file:py-2 file:px-4
                                        file:rounded-full file:border-0
                                        file:text-sm file:font-semibold
                                        file:bg-blue-700 file:text-white
                                        hover:file:bg-blue-800">
                                    @if (!empty($product_to_edit['pdf_path']))
                                        <p class="mt-2 text-xs text-gray-500">Current: {{ basename($product_to_edit->pdf_path) }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex items-center">
                                    <input id="is_hidden" name="is_hidden" type="checkbox" value="1" 
                                        @checked(old('is_hidden', $product_to_edit->is_hidden ?? false))
                                        class="h-5 w-5 rounded border-gray-300 text-blue-700 focus:ring-blue-700">
                                    <label for="is_hidden" class="ml-2 block text-sm font-bold text-gray-700">
                                        Hide this product from the public website?
                                    </label>
                                </div>
                                <p class="ml-7 text-xs text-gray-500 mt-1">If checked, this product will only be visible to Admins and internal staff in the Inventory system.</p>
                            </div>

                            <div class="flex items-center gap-4">
                                <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded-lg shadow-lg transition-all">
                                    {{ $action === 'edit' ? 'Update' : 'Save' }} Product
                                </button>
                                <a href="{{ route('admin.products.list') }}" class="text-gray-600 hover:text-gray-800 font-medium underline">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        @else
            
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-white drop-shadow-sm">Manage Products</h1>
                <a href="{{ route('admin.products.create') }}" class="mt-4 md:mt-0 bg-blue-700 hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-lg transition-all">
                    Add New Product
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
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Product Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Brand</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider">Category</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden md:table-cell">Last Updated</th>
                                <th scope="col" class="px-6 py-4 text-left text-sm font-bold uppercase tracking-wider hidden md:table-cell">Hidden</th>
                                <th scope="col" class="px-6 py-4 text-center text-sm font-bold uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($products as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ $product->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->brand->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $product->category->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 hidden md:table-cell">
                                        <span class="block">{{ $product->lastUpdatedBy->name ?? 'N/A' }}</span>
                                        <span class="text-xs">{{ $product->updated_at->format('M j, Y, g:i a') }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        @if($product->is_hidden)
                                            <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-600 text-white">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                                Hidden
                                            </span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center items-center space-x-2">
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="bg-yellow-400 hover:bg-yellow-500 text-yellow-900 py-1 px-3 rounded font-bold shadow-sm transition-colors">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white py-1 px-3 rounded font-bold shadow-sm transition-colors" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">No products found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
</main>
@endsection