<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Models\Inventories\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the inventory.
     */
    public function index()
    {
        // Get all products with their inventory data
        $products = Product::with(['inventory', 'brand', 'category'])->get();
        
        return view('inventory.manage', [
            'action' => 'list',
            'products' => $products
        ]);
    }

    /**
     * Show the form for editing the inventory stock.
     * NOTE: We treat 'edit' as selecting a specific product to update stock.
     */
    public function edit($id) // Note: $id here refers to the PRODUCT ID, not inventory ID
    {
        $product = Product::with('inventory')->findOrFail($id);
        
        // We need the full list for the table background, or we can just show the form
        // Let's show just the form for simplicity and focus
        return view('inventory.manage', [
            'action' => 'edit',
            'product_to_edit' => $product,
            'current_stock' => $product->inventory->stock ?? 0
        ]);
    }

    /**
     * Update the stock.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        // Update or Create the inventory record
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