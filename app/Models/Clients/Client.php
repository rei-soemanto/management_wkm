<?php

namespace App\Models\Clients;

use App\Models\Managements\ManagementProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'pic_name',
        'email',
    ];

    public function managementProjects()
    {
        return $this->hasMany(ManagementProject::class, 'client_id');
    }
}