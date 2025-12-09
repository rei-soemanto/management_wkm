<?php

namespace App\Http\Controllers;

use App\Models\Managements\ManagementProject;
use App\Models\Inventories\ProductInventory;
use App\Models\Inventories\ProductProjectUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectAllocationController extends Controller
{
    // Show Allocate Product form
    public function create($projectId)
    {
        $project = ManagementProject::findOrFail($projectId);
        
        // Get inventory items that have stock > 0
        $inventory = ProductInventory::with('product')->get();

        return view('projects.allocate_product', compact('project', 'inventory'));
    }

    // Process Allocation
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'product_inventory_id' => 'required|exists:product_inventories,id',
            'quantity_needed' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:0',
        ]);

        return DB::transaction(function () use ($request, $projectId) {
            $inventory = ProductInventory::lockForUpdate()->find($request->product_inventory_id);

            // Allocated cannot more than stock
            if ($request->quantity_allocated > $inventory->stock) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity_allocated' => "Cannot allocate {$request->quantity_allocated}. Only {$inventory->stock} available in stock."
                ]);
            }

            // Allocated cannot more than needed
            if ($request->quantity_allocated > $request->quantity_needed) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity_allocated' => "Allocated amount cannot exceed the needed amount."
                ]);
            }

            // Deduct Stock
            if ($request->quantity_allocated > 0) {
                $inventory->decrement('stock', $request->quantity_allocated);
            }

            // Create Usage Record
            ProductProjectUsage::create([
                'management_project_id' => $projectId,
                'product_inventory_id' => $inventory->id,
                'quantity_needed' => $request->quantity_needed,
                'quantity' => $request->quantity,
            ]);

            return redirect()->route('projects.show', $projectId)->with('success', 'Product allocated successfully.');
        });
    }

    // Update Allocation
    public function update(Request $request, $projectId, $usageId)
    {
        $request->validate([
            'add_quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request, $projectId, $usageId) {
            $usage = ProductProjectUsage::with('inventoryItem')->findOrFail($usageId);
            $inventory = $usage->inventoryItem;

            // Calculate how many are still needed
            $remaining_needed = $usage->quantity_needed - $usage->quantity;

            if ($request->add_quantity > $remaining_needed) {
                return back()->with('error', "You are trying to add more than needed.");
            }

            if ($request->add_quantity > $inventory->stock) {
                return back()->with('error', "Not enough stock in inventory to add that amount.");
            }

            // Update Inventory and Usage
            $inventory->decrement('stock', $request->add_quantity);
            $usage->increment('quantity', $request->add_quantity);

            return redirect()->route('projects.show', $projectId)->with('success', 'Additional stock allocated to project.');
        });
    }

    // Remove Allocation
    public function destroy($projectId, $usageId)
    {
        return DB::transaction(function () use ($projectId, $usageId) {
            $usage = ProductProjectUsage::where('management_project_id', $projectId)
                ->where('id', $usageId)
                ->firstOrFail();

            // Return stock to inventory
            if ($usage->quantity > 0) {
                $usage->inventoryItem->increment('stock', $usage->quantity);
            }

            // Delete usage record
            $usage->delete();

            return redirect()->route('projects.show', $projectId)->with('success', 'Allocation removed. Stock returned to inventory.');
        });
    }
}