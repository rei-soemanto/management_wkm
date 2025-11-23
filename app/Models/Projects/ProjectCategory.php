<?php

namespace App\Models\Projects;

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
}