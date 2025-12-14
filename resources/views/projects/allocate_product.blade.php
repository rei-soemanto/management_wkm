@extends('layout.mainlayout')
@section('name', 'Allocate Product')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-[#0f0f0f] shadow rounded-lg p-6">
        <h2 class="text-xl text-[#e0bb35] font-bold mb-4">Add Product Requirement</h2>
        <p class="text-gray-300 mb-6">Project: <strong>{{ $project->name }}</strong></p>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.allocation.store', $project->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[#e0bb35]">Select Product</label>
                <input type="text" id="productSearch" placeholder="Type name to filter..." 
                class="block w-full rounded-md bg-[#1a1a1a] border-gray-600 text-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2 mb-2">

                <select name="product_inventory_id" id="productSelect" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                    @foreach($inventory as $item)
                        <option value="{{ $item->id }}" data-stock="{{ $item->stock }}" data-search="{{ strtolower($item->product->name) }}">
                            {{ $item->product->name }} (Available Stock: {{ $item->stock }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-[#e0bb35]">Quantity Needed</label>
                    <p class="text-xs text-gray-400 mb-1">Total required for project</p>
                    <input type="number" name="quantity_needed" id="qtyNeeded" min="1" value="1" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] text-gray-300 px-3 py-2 bg-[#0f0f0f]">
                </div>

                <div>
                    <label class="block text-sm font-medium text-[#e0bb35]">Allocate Now</label>
                    <p class="text-xs text-gray-400 mb-1">Take from inventory immediately</p>
                    <input type="number" name="quantity_allocated" id="qtyAllocated" min="0" value="0" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] text-gray-300 px-3 py-2 bg-[#0f0f0f]">
                </div>
            </div>
            
            <p id="stockWarning" class="text-red-500 text-xs hidden">Warning: Allocation exceeds available stock!</p>

            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#e0bb35] text-black rounded-md hover:bg-[#e3cf85]">Add Requirement</button>
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

        function checkStock() {
            const selectedOption = selectDropdown.options[selectDropdown.selectedIndex];
            const stock = parseInt(selectedOption.getAttribute('data-stock')) || 0;
            const allocated = parseInt(qtyAllocated.value) || 0;

            if (allocated > stock) {
                stockWarning.classList.remove('hidden');
                stockWarning.textContent = `Cannot allocate ${allocated}. Only ${stock} in stock.`;
            } else {
                stockWarning.classList.add('hidden');
            }
        }

        selectDropdown.addEventListener('change', checkStock);
        qtyAllocated.addEventListener('input', checkStock);

        const originalOptions = Array.from(selectDropdown.options).slice(0); 
        searchInput.addEventListener('input', function() {
            const filter = this.value.toLowerCase();
            selectDropdown.innerHTML = '';
            const matchingOptions = originalOptions.filter(option => {
                const text = option.getAttribute('data-search');
                return text && text.includes(filter);
            });
            matchingOptions.forEach(option => selectDropdown.appendChild(option));
            if (matchingOptions.length > 0) selectDropdown.value = matchingOptions[0].value;
            checkStock();
        });
    });
</script>
@endsection