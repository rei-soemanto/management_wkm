<?php

namespace App\Models\Users;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Inventories\ProductInventory;
use App\Models\Managements\ManagementProjectProgress;
use App\Models\Managements\ManagementProjectRoleAssignment;
use App\Models\Products\Product;
use App\Models\Services\Service;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    public function projectRoleAssignments()
    {
        return $this->hasMany(ManagementProjectRoleAssignment::class, 'user_id');
    }

    public function projectProgressLogs()
    {
        return $this->hasMany(ManagementProjectProgress::class, 'user_id');
    }

    public function inventoryUpdates()
    {
        return $this->hasMany(ProductInventory::class, 'last_update_by');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'last_updated_by');
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'last_updated_by');
    }

    public function interested_products()
    {
        return $this->belongsToMany(
            Product::class,
            'interested_products',
            'user_id',
            'product_id'
        );
    }

    public function interested_services()
    {
        return $this->belongsToMany(
            Service::class,
            'interested_services',
            'user_id',
            'service_id'
        );
    }
}