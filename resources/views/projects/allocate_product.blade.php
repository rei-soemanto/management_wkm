@extends('layout.mainlayout')
@section('name', 'Allocate Product')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-6 md:py-10">
    <div class="bg-[#0f0f0f] shadow-lg rounded-lg p-5 md:p-8 border border-gray-800">
        <h2 class="text-xl text-[#e0bb35] font-bold mb-2">Add Product Requirement</h2>
        <p class="text-sm text-gray-400 mb-6">Project: <span class="text-gray-100 font-bold">{{ $project->name }}</span></p>

        @if ($errors->any())
            <div class="bg-red-900/20 border border-red-500 text-red-200 px-4 py-3 rounded mb-6 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.allocation.store', $project->id) }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="block text-sm font-bold text-[#e0bb35]">Select Product</label>
                
                <input type="text" id="productSearch" placeholder="Filter by name, brand, or category..." 
                    class="block w-full rounded-md bg-[#1a1a1a] border-gray-600 text-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm px-4 py-2.5 outline-none">

                <select name="product_inventory_id" id="productSelect" 
                    class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-600 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm text-gray-300 px-3 py-2.5 outline-none transition cursor-pointer">
                    
                    <option value="" disabled selected>-- Choose a Product --</option>

                    @foreach($inventory as $item)
                        <option value="{{ $item->id }}" data-stock="{{ $item->stock }}" data-search="{{ strtolower($item->product->name . ' ' . ($item->product->brand->name ?? '') . ' ' . ($item->product->category->name ?? '')) }}">
                            {{ $item->product->name }} 
                            @if($item->product->brand) - {{ $item->product->brand->name }} @endif
                            (Stock: {{ $item->stock }})
                        </option>
                    @endforeach
                </select>
                
                <div id="noResults" class="hidden text-xs text-red-400 mt-1 ml-1">
                    No products match your search.
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-[#e0bb35]">Quantity Needed</label>
                    <p class="text-[11px] text-gray-500 mb-1 italic">Total required for project scope</p>
                    <input type="number" name="quantity_needed" id="qtyNeeded" min="1" value="1" 
                        class="block w-full rounded-md border-gray-600 bg-[#1a1a1a] text-gray-200 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm px-4 py-2.5 outline-none">
                </div>

                <div>
                    <label class="block text-sm font-bold text-[#e0bb35]">Allocate Now</label>
                    <p class="text-[11px] text-gray-500 mb-1 italic">Deduct from inventory today</p>
                    <input type="number" name="quantity_allocated" id="qtyAllocated" min="0" value="0" 
                        class="block w-full rounded-md border-gray-600 bg-[#1a1a1a] text-gray-200 shadow-sm focus:border-[#e0bb35] focus:ring-1 focus:ring-[#e0bb35] text-sm px-4 py-2.5 outline-none">
                </div>
            </div>
            
            <div id="stockWarning" class="hidden p-3 bg-red-900/30 border border-red-800 rounded">
                <p class="text-red-400 text-xs font-bold flex items-center gap-2">
                    <span>⚠️</span> <span id="warningText"></span>
                </p>
            </div>

            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-gray-800">
                <a href="{{ route('projects.show', $project->id) }}" 
                    class="flex items-center justify-center px-4 py-2 text-sm text-gray-400 hover:text-white transition">
                    Cancel
                </a>
                <button type="submit" 
                    class="flex items-center justify-center px-6 py-2.5 bg-[#e0bb35] text-black font-bold rounded hover:bg-[#c9a72e] transition active:scale-95">
                    Add Requirement
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('productSearch');
        const selectDropdown = document.getElementById('productSelect');
        const qtyAllocated = document.getElementById('qtyAllocated');
        const stockWarning = document.getElementById('stockWarning');
        const warningText = document.getElementById('warningText');

        function checkStock() {
            const selectedOption = selectDropdown.options[selectDropdown.selectedIndex];
            if (!selectedOption) return;

            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const allocated = parseInt(qtyAllocated.value) || 0;

            if (allocated > stock) {
                stockWarning.classList.remove('hidden');
                warningText.textContent = `Insufficient Stock: Cannot allocate ${allocated}. Only ${stock} available.`;
            } else {
                stockWarning.classList.add('hidden');
            }
        }

        selectDropdown.addEventListener('change', checkStock);
        qtyAllocated.addEventListener('input', checkStock);

        const originalOptions = Array.from(selectDropdown.options); 
        
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            selectDropdown.innerHTML = '';
            
            const matchingOptions = originalOptions.filter(option => {
                const text = option.getAttribute('data-search');
                return text && text.includes(filter);
            });

            matchingOptions.forEach(option => selectDropdown.appendChild(option));
            
            if (matchingOptions.length > 0) {
                selectDropdown.value = matchingOptions[0].value;
            }
            checkStock();
        });
    });
</script>
@endsection