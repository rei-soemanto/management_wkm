<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Models\Inventories\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductInventoryController extends Controller
{
    // Display list of inventory.
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Product::withCount(['inventory', 'brand', 'category'])->latest();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhereHas('brand', fn($q) => $q->where('name', 'like', "%{$search}%"))->orWhereHas('category', fn($q) => $q->where('name', 'like', "%{$search}%"));
            });
        }

        $products = $query->paginate(10);

        return view('inventory.manage', [
            'action' => 'list',
            'products' => $products,
            'search' => $search
        ]);
    }

    // Show form for edit inventory stock.
    public function edit($id)
    {
        $product = Product::with('inventory')->findOrFail($id);
        
        return view('inventory.manage', [
            'action' => 'edit',
            'product_to_edit' => $product,
            'current_stock' => $product->inventory->stock ?? 0
        ]);
    }

    // Update stock.
    public function update(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        // Update or Create inventory record
        ProductInventory::updateOrCreate(
            ['product_id' => $product->id],
            [
                'stock' => $request->stock,
                'last_update_by' => Auth::id()
            ]
        );

        return redirect()->route('inventory.index')
            ->with('success', "Stock for {$product->name} updated successfully.");
    }
}