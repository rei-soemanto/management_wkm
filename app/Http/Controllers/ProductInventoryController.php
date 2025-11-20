<?php

namespace App\Http\Controllers;

use App\Models\Products\Product;
use App\Models\Inventories\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductInventoryController extends Controller
{
    /**
     * Display a listing of the inventory (Stock Dashboard).
     */
    public function index()
    {
        // Get all products, load their inventory and brand info
        $products = Product::with(['inventory', 'brand', 'category'])->get();
        
        return view('inventory.index', compact('products'));
    }

    /**
     * Update the stock for a specific product.
     * NOTE: We use updateOrCreate so it works even if stock hasn't been set yet.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product = Product::findOrFail($id);

        // Update or Create the inventory record
        ProductInventory::updateOrCreate(
            ['product_id' => $product->id], // Search criteria
            [
                'stock' => $request->stock,
                'last_update_by' => Auth::id() // Log who changed it
            ]
        );

        return redirect()->route('inventory.index')
            ->with('success', "Stock for {$product->name} updated successfully.");
    }
}