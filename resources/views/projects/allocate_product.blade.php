@extends('layout.mainlayout')
@section('name', 'Allocate Product')
@section('content')
<div class="max-w-2xl mx-auto px-4 py-8">
    <div class="bg-[#0f0f0f] shadow rounded-lg p-6">
        <h2 class="text-xl text-[#e0bb35] font-bold mb-4">Allocate Product from Inventory</h2>
        <p class="text-gray-300 mb-6">Project: <strong>{{ $project->name }}</strong></p>

        <form action="{{ route('projects.allocation.store', $project->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-[#e0bb35]">Select Product</label>

                <input type="text" id="productSearch" placeholder="Type name or email to filter..." 
                class="block w-full rounded-md bg-[#1a1a1a] border-gray-600 text-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm px-3 py-2 mb-2">

                <select name="product_inventory_id" id="productSelect" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                    @foreach($inventory as $item)
                        <option value="{{ $item->id }}" data-search="{{ strtolower($item->product->name) }}">
                            {{ $item->product->name }} (Stock: {{ $item->stock }})
                        </option>
                    @endforeach
                </select>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.getElementById('productSearch');
                        const selectDropdown = document.getElementById('productSelect');

                        const originalOptions = Array.from(selectDropdown.options).slice(1); 

                        searchInput.addEventListener('input', function() {
                            const filter = this.value.toLowerCase();

                            selectDropdown.innerHTML = '<option value="">-- Select Product --</option>';

                            const matchingOptions = originalOptions.filter(option => {
                                const text = option.getAttribute('data-search');
                                return text && text.includes(filter);
                            });

                            matchingOptions.forEach(option => {
                                selectDropdown.appendChild(option);
                            });

                            if (matchingOptions.length > 0) {
                                selectDropdown.value = matchingOptions[0].value;
                            }
                        });
                    });
                </script>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#e0bb35]">Quantity to Use</label>
                <input type="number" name="quantity" min="1" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] text-gray-300 px-3 py-2">
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#e0bb35] text-black rounded-md hover:bg-[#e3cf85]">Allocate</button>
            </div>
        </form>
    </div>
</div>
@endsection