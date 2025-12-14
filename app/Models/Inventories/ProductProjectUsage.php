<?php

namespace App\Models\Inventories;

use App\Models\Managements\ManagementProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductProjectUsage extends Model
{
    use HasFactory;

    protected $table = 'product_project_usages';

    protected $fillable = [
        'management_project_id',
        'product_inventory_id',
        'quantity_needed',
        'quantity',
    ];

    public function managementProject()
    {
        return $this->belongsTo(ManagementProject::class, 'management_project_id');
    }

    public function inventoryItem()
    {
        return $this->belongsTo(ProductInventory::class, 'product_inventory_id');
    }
}