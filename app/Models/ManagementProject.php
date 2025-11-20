<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementProject extends Model
{
    use HasFactory;

    protected $table = 'management_projects';

    protected $fillable = [
        'status_id',
        'client_id',
        'name',
        'description',
        'due_date',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function progressLogs()
    {
        return $this->hasMany(ManagementProjectProgress::class, 'management_project_id');
    }

    public function roleAssignments()
    {
        return $this->hasMany(ManagementProjectRoleAssignment::class, 'management_project_id');
    }

    public function productUsages()
    {
        return $this->hasMany(ProductProjectUsage::class, 'management_project_id');
    }
}