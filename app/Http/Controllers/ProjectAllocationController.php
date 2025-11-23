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
        $inventory = ProductInventory::where('stock', '>', 0)->with('product')->get();

        return view('projects.allocate_product', compact('project', 'inventory'));
    }

    // Process Allocation
    public function store(Request $request, $projectId)
    {
        $request->validate([
            'product_inventory_id' => 'required|exists:product_inventories,id',
            'quantity' => 'required|integer|min:1',
        ]);

        return DB::transaction(function () use ($request, $projectId) {
            $inventory = ProductInventory::lockForUpdate()->find($request->product_inventory_id);

            // Check Stock
            if ($inventory->stock < $request->quantity) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'quantity' => "Not enough stock. Only {$inventory->stock} available."
                ]);
            }

            // Deduct Stock
            $inventory->decrement('stock', $request->quantity);

            // Create Usage Record
            ProductProjectUsage::create([
                'management_project_id' => $projectId,
                'product_inventory_id' => $inventory->id,
                'quantity' => $request->quantity,
            ]);

            return redirect()->route('projects.show', $projectId)->with('success', 'Product allocated successfully.');
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
            $usage->inventoryItem->increment('stock', $usage->quantity);

            // Delete usage record
            $usage->delete();

            return redirect()->route('projects.show', $projectId)->with('success', 'Allocation removed. Stock returned to inventory.');
        });
    }
}