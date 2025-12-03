<?php

namespace App\Models\Projects;

use App\Models\Managements\ManagementProject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectCategory extends Model
{
    use HasFactory;

    protected $table = 'project_categories';

    protected $fillable = ['name'];

    public function projects()
    {
        return $this->belongsToMany(
            Project::class,
            'project_category_assignments',
            'category_id',
            'project_id'
        );
    }

    public function managementProjects()
    {
        return $this->belongsToMany(
            ManagementProject::class,
            'management_project_category_assignments',
            'project_category_id',
            'management_project_id'
        );
    }
}