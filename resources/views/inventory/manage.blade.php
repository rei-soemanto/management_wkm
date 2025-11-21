@extends('layout.mainlayout')

@section('name', 'Manage Inventory')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    @if ($action === 'edit')
        
        {{-- ===========================
             FORM VIEW (Update Stock)
           =========================== --}}
        <div class="max-w-2xl mx-auto">
            <div class="mb-8">
                <a href="{{ route('inventory.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center transition-colors">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Inventory
                </a>
                <h1 class="text-3xl font-bold text-gray-900 mt-2">Update Stock</h1>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100 p-8">
                <div class="flex items-start gap-6 mb-8">
                    {{-- Product Image --}}
                    @if($product_to_edit->image)
                        <img src="{{ asset('storage/' . $product_to_edit->image) }}" alt="{{ $product_to_edit->name }}" class="w-24 h-24 object-cover rounded-lg shadow-sm">
                    @else
                        <div class="w-24 h-24 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif

                    <div>
                        <h2 class="text-xl font-bold text-gray-900">{{ $product_to_edit->name }}</h2>
                        <p class="text-sm text-gray-500">{{ $product_to_edit->brand->name ?? 'Unknown Brand' }} • {{ $product_to_edit->category->name ?? 'Unknown Category' }}</p>
                        <p class="mt-2 text-sm text-gray-600 max-w-md line-clamp-2">{{ $product_to_edit->description }}</p>
                    </div>
                </div>

                <form action="{{ route('inventory.update', $product_to_edit->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="stock" class="block text-sm font-bold text-gray-700 mb-1">Current Stock Level</label>
                        <div class="flex items-center">
                            <button type="button" onclick="adjustStock(-1)" class="p-3 bg-gray-100 hover:bg-gray-200 rounded-l-md border border-r-0 border-gray-300 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                            </button>
                            <input type="number" name="stock" id="stock" value="{{ old('stock', $current_stock) }}" min="0" required 
                                class="block w-full text-center border-gray-300 focus:ring-blue-500 focus:border-blue-500 sm:text-lg font-bold py-2.5">
                            <button type="button" onclick="adjustStock(1)" class="p-3 bg-gray-100 hover:bg-gray-200 rounded-r-md border border-l-0 border-gray-300 text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </button>
                        </div>
                        <p class="mt-2 text-xs text-gray-500">Enter the total physical quantity available in the warehouse.</p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('inventory.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 shadow-sm transition-colors">
                            Save Stock
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function adjustStock(amount) {
                const input = document.getElementById('stock');
                let val = parseInt(input.value) || 0;
                val += amount;
                if(val < 0) val = 0;
                input.value = val;
            }
        </script>

    @else
        
        {{-- ===========================
             LIST VIEW (Table)
           =========================== --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Product Inventory</h1>
                <p class="text-gray-500 mt-1">Real-time stock levels for all catalog items.</p>
            </div>
            
            {{-- Stats (Optional Polish) --}}
            <div class="mt-4 md:mt-0 flex gap-4">
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 text-center">
                    <span class="block text-xs text-gray-500 uppercase font-bold">Total Items</span>
                    <span class="text-xl font-bold text-gray-900">{{ $products->sum(fn($p) => $p->inventory->stock ?? 0) }}</span>
                </div>
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 text-center">
                    <span class="block text-xs text-gray-500 uppercase font-bold">Low Stock</span>
                    <span class="text-xl font-bold text-red-600">{{ $products->filter(fn($p) => ($p->inventory->stock ?? 0) < 5)->count() }}</span>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-md">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider w-20">Image</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Stock Level</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Last Updated</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->image)
                                        <img class="h-10 w-10 rounded-lg object-cover border border-gray-200" src="{{ asset('storage/' . $product->image) }}" alt="">
                                    @else
                                        <div class="h-10 w-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $product->brand->name ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                        {{ $product->category->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @php
                                        $stock = $product->inventory->stock ?? 0;
                                        $color = $stock > 10 ? 'bg-green-100 text-green-800' : ($stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800');
                                    @endphp
                                    <span class="px-3 py-1 inline-flex text-sm font-bold rounded-full {{ $color }}">
                                        {{ $stock }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if($product->inventory && $product->inventory->updated_at)
                                        <div class="flex flex-col">
                                            <span>{{ $product->inventory->updated_at->format('M d, Y') }}</span>
                                            <span class="text-xs text-gray-400">{{ $product->inventory->updated_at->diffForHumans() }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 italic">Never</span>
                                    @endif
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if(Auth::user()->userRole->name === 'Admin')
                                        {{-- 
                                            Using a route parameter here. 
                                            The route must be: Route::get('/inventory/{id}/edit', ...)->name('inventory.edit');
                                            Wait! We didn't add the 'edit' route in web.php yet. 
                                            I will remind you to add it below.
                                        --}}
                                        <a href="{{ route('inventory.edit', $product->id) }}" class="text-blue-600 hover:text-blue-900 font-bold hover:underline">
                                            Update Stock
                                        </a>
                                    @else
                                        <span class="text-gray-400 cursor-not-allowed">View Only</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-10 text-center text-gray-500 italic">No products found in catalog.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @endif
</div>
@endsection