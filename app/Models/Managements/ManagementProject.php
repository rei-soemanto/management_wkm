<?php

namespace App\Models\Managements;

use App\Models\Clients\Client;
use App\Models\Inventories\ProductProjectUsage;
use App\Models\Projects\ProjectCategory;
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

    public function categories()
    {
        return $this->belongsToMany(
            ProjectCategory::class,
            'management_project_category_assignments',
            'management_project_id',
            'project_category_id'
        );
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

    public function tasks()
    {
        return $this->hasMany(ManagementProjectTask::class, 'management_project_id');
    }
}