<?php

namespace App\Models\Products;

use App\Models\Inventories\ProductInventory;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'brand_id',
        'category_id',
        'name',
        'description',
        'image',
        'pdf_path',
        'last_update_by',
        'is_hidden',
    ];

    protected $casts = [
        'is_hidden' => 'boolean',
    ];

    public function brand()
    {
        return $this->belongsTo(ProductBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_update_by');
    }

    public function inventory()
    {
        return $this->hasOne(ProductInventory::class, 'product_id');
    }
}