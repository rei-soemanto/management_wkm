<?php

namespace App\Models\Services;

use App\Models\Services\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $table = 'service_categories';

    protected $fillable = ['name'];

    public function services()
    {
        return $this->hasMany(Service::class, 'category_id');
    }
}