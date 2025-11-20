<?php

namespace App\Models\Inventories;

use App\Models\Products\Product;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInventory extends Model
{
    use HasFactory;

    protected $table = 'product_inventories';

    protected $fillable = [
        'product_id',
        'stock',
        'last_update_by',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_update_by');
    }

    public function projectUsages()
    {
        return $this->hasMany(ProductProjectUsage::class, 'product_inventory_id');
    }
}