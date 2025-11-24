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
                <select name="product_inventory_id" class="mt-1 block w-full rounded-md bg-[#0f0f0f] border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] sm:text-sm text-gray-300 px-3 py-2">
                    @foreach($inventory as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->product->name }} (Available: {{ $item->stock }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-[#e0bb35]">Quantity to Use</label>
                <input type="number" name="quantity" min="1" value="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#e0bb35] focus:ring-[#e0bb35] text-gray-300 px-3 py-2">
                @error('quantity') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('projects.show', $project->id) }}" class="px-4 py-2 text-gray-300">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-[#e0bb35] text-black rounded-md hover:bg-[#e3cf85]">Allocate</button>
            </div>
        </form>
    </div>
</div>
@endsection