@extends('layout.mainlayout')

@section('name', 'Manage Inventory')

@section('content')
<main class="min-h-[597px] bg-[#0a0a0a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

        @if ($action === 'edit')
            {{-- UPDATE STOCK VIEW --}}
            <div class="max-w-2xl mx-auto">
                <div class="mb-8">
                    <a href="{{ route('inventory.index') }}" class="text-sm text-white hover:text-[#e0bb35] flex items-center transition-colors font-bold uppercase">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back to Inventory
                    </a>
                    <h1 class="text-3xl font-bold text-[#e0bb35] mt-2">Update Stock</h1>
                </div>

                <div class="bg-[#0f0f0f] shadow-2xl rounded-xl overflow-hidden border border-gray-700 p-8">
                    <div class="flex items-start gap-6 mb-8">
                        <div class="shrink-0">
                            @if($product_to_edit->image)
                                <img src="{{ asset('storage/' . $product_to_edit->image) }}" alt="{{ $product_to_edit->name }}" class="w-24 h-24 object-cover rounded-lg border border-gray-600 shadow-lg">
                            @else
                                <div class="w-24 h-24 bg-gray-900 rounded-lg flex items-center justify-center text-gray-500 border border-gray-700">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1 w-full">
                            <h2 class="text-xl font-bold text-[#e0bb35]">{{ $product_to_edit->name }}</h2>
                            <p class="text-sm text-white">{{ $product_to_edit->brand->name ?? 'Unknown Brand' }} • {{ $product_to_edit->category->name ?? 'Unknown Category' }}</p>
                            <p class="mt-2 text-sm text-white leading-relaxed opacity-80 wrap-break-words">{{ $product_to_edit->description }} </p>
                        </div>
                    </div>

                    <form action="{{ route('inventory.update', $product_to_edit->id) }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="stock" class="block text-sm font-bold text-[#e0bb35] mb-2 uppercase tracking-wider">Stock Level</label>
                            <div class="flex items-center">
                                <button type="button" onclick="adjustStock(-1)" class="p-3 bg-[#e0bb35] hover:bg-[#f2cc4a] rounded-l-md text-black font-bold transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path></svg>
                                </button>
                                <input type="number" name="stock" id="stock" value="{{ old('stock', $current_stock) }}" min="0" oninput="validity.valid||(value='');" required 
                                    class="block w-full text-center bg-black border-y border-gray-700 text-[#e0bb35] text-xl font-bold py-2 focus:ring-0">
                                <button type="button" onclick="adjustStock(1)" class="p-3 bg-[#e0bb35] hover:bg-[#f2cc4a] rounded-r-md text-black font-bold transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </button>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-800 flex justify-end gap-3">
                            <a href="{{ route('inventory.index') }}" class="px-6 py-2 bg-white text-black rounded-md font-bold text-xs uppercase hover:bg-gray-200 transition-colors flex items-center">Cancel</a>
                            <button type="submit" class="px-6 py-2 bg-[#e0bb35] rounded-md font-bold text-xs text-black uppercase hover:bg-[#f2cc4a] transition-colors">Save Stock</button>
                        </div>
                    </form>
                </div>
            </div>

        @else
            {{-- INVENTORY LIST VIEW --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-6">
                <div class="text-center md:text-left">
                    <h1 class="text-3xl md:text-4xl font-bold text-[#e0bb35]">Product Inventory</h1>
                    <p class="text-white mt-1">Real-time stock tracking and management.</p>
                </div>

                <div class="flex flex-col md:flex-row items-center gap-4 w-full md:max-w-2xl">
                    <form action="{{ route('inventory.index') }}" method="GET" class="w-full">
                        <div class="relative group">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products, brands, or categories..." 
                                class="w-full bg-[#0f0f0f] text-white border border-gray-700 rounded-lg py-2.5 px-4 pl-10 focus:ring-2 focus:ring-[#e0bb35] outline-none">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400 group-focus-within:text-[#e0bb35]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                    </form>

                    <div class="flex gap-2">
                        <div class="bg-black px-4 py-2 rounded-lg border border-gray-600 text-center min-w-[100px]">
                            <span class="block text-[10px] text-gray-400 uppercase font-bold">Total Items</span>
                            <span class="text-xl font-bold text-[#e0bb35]">{{ $products->sum(fn($p) => $p->inventory->stock ?? 0) }}</span>
                        </div>
                        <div class="bg-black px-4 py-2 rounded-lg border border-red-900 text-center min-w-[100px]">
                            <span class="block text-[10px] text-red-500 uppercase font-bold">Low Stock</span>
                            <span class="text-xl font-bold text-red-500">{{ $products->filter(fn($p) => ($p->inventory->stock ?? 0) < 5)->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>

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
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest hidden sm:table-cell">IMG</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest">Product Info</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest hidden md:table-cell">Category</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Stock Level</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-widest hidden lg:table-cell">Last Sync</th>
                                <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-widest">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-800">
                            @forelse($products as $product)
                                <tr class="hover:bg-white/5 transition-colors">
                                    {{-- Image Column --}}
                                    <td class="px-6 py-4 hidden sm:table-cell">
                                        <div class="h-12 w-12 rounded-lg overflow-hidden border border-gray-700 bg-gray-900">
                                            @if($product->image)
                                                <img class="h-full w-full object-cover" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <div class="h-full w-full flex items-center justify-center text-gray-700">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Product Info Column --}}
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-bold text-[#e0bb35] uppercase">{{ $product->name }}</div>
                                        <div class="text-xs text-white opacity-80">{{ $product->brand->name ?? 'No Brand' }}</div>
                                    </td>

                                    {{-- Category Column --}}
                                    <td class="px-6 py-4 hidden md:table-cell">
                                        <span class="px-2.5 py-1 text-[10px] font-bold rounded bg-gray-800 text-white border border-gray-600 uppercase">
                                            {{ $product->category->name ?? 'General' }}
                                        </span>
                                    </td>

                                    {{-- Stock Column with Circle --}}
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $stock = $product->inventory->stock ?? 0;
                                            $circleStyle = $stock >= 10 
                                                ? 'bg-green-900/30 text-green-400 border-green-500/50' 
                                                : ($stock > 0 ? 'bg-yellow-900/30 text-yellow-400 border-yellow-500/50' : 'bg-red-900/30 text-red-500 border-red-500/50');
                                        @endphp
                                        <div class="inline-flex items-center justify-center w-10 h-10 rounded-full border {{ $circleStyle }} font-bold text-sm">
                                            {{ $stock }}
                                        </div>
                                    </td>

                                    {{-- Timestamp Column --}}
                                    <td class="px-6 py-4 hidden lg:table-cell">
                                        @if($product->inventory && $product->inventory->updated_at)
                                            <div class="text-xs text-white">{{ $product->inventory->updated_at->format('M d, Y') }}</div>
                                            <div class="text-[10px] text-gray-500 italic">{{ $product->inventory->updated_at->diffForHumans() }}</div>
                                        @else
                                            <span class="text-xs text-gray-600 uppercase">No Record</span>
                                        @endif
                                    </td>

                                    {{-- Actions Column --}}
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            @if(Auth::user()->userRole->name === 'Admin')
                                                <a href="{{ route('inventory.edit', $product->id) }}" 
                                                class="bg-[#e0bb35] hover:bg-[#f2cc4a] text-black text-[10px] font-bold py-1.5 px-3 rounded uppercase transition-all shadow-md">
                                                    Update
                                                </a>
                                            @endif

                                            <button type="button" 
                                                class="sidebar-details-trigger bg-gray-800 hover:bg-gray-700 text-white text-[10px] font-bold py-1.5 px-3 rounded uppercase transition-all border border-gray-600"
                                                data-sidebar-title="Item Specifications"
                                                data-sidebar-schema="{{ json_encode([
                                                    ['type' => 'image', 'value' => asset('storage/' . $product->image)],
                                                    ['type' => 'header', 'label' => 'Product Name', 'value' => $product->name],
                                                    ['type' => 'lead', 'value' => $product->description ?? 'No description provided for this item.'],
                                                    ['type' => 'grid', 'items' => [
                                                        ['label' => 'Brand', 'value' => $product->brand->name ?? 'N/A'],
                                                        ['label' => 'Category', 'value' => $product->category->name ?? 'General'],
                                                        ['label' => 'Stock Level', 'value' => (string)($product->inventory->stock ?? 0)],
                                                        ['label' => 'Last Sync', 'value' => $product->inventory?->updated_at?->diffForHumans() ?? 'Never']
                                                    ]],
                                                    ['type' => 'badge-list', 'label' => 'Category & Brand', 'value' => ($product->category->name ?? 'Inventory') . ', ' . ($product->brand->name ?? 'Stock')]
                                                ]) }}">
                                                Details
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-20 text-center text-gray-500 italic">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 mb-4 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                            <p class="text-lg">No products found in the catalog.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination Section --}}
            <div class="mt-8">
                <style>
                    nav[role="navigation"] .hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between div:first-child p { color: #9ca3af !important; }
                    nav[role="navigation"] span[aria-current="page"] span { background-color: #e0bb35 !important; color: black !important; border-color: #e0bb35 !important; font-weight: bold; }
                    nav[role="navigation"] a { background-color: #0f0f0f !important; color: white !important; border-color: #374151 !important; transition: all 0.2s; }
                    nav[role="navigation"] a:hover { border-color: #e0bb35 !important; color: #e0bb35 !important; }
                    nav[role="navigation"] span[aria-disabled="true"] span { background-color: #0f0f0f !important; color: #4b5563 !important; border-color: #374151 !important; }
                </style>
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
    </div>
</main>

<script>
    /* Logic to handle the manual increment and decrement of the stock input field. */
    function adjustStock(amount) {
        const input = document.getElementById('stock');
        if (!input) return;
        
        let val = parseInt(input.value) || 0;
        val += amount;
        
        if (val < 0) val = 0;
        input.value = val;
    }
</script>
@endsection