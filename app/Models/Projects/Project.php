<?php

namespace App\Models\Projects;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'name',
        'description',
        'last_update_by',
    ];

    public function images()
    {
        return $this->hasMany(ProjectImage::class, 'project_id');
    }

    public function categories()
    {
        return $this->belongsToMany(
            ProjectCategory::class,
            'project_category_assignments',
            'project_id',
            'category_id'
        );
    }

    public function lastUpdatedBy()
    {
        return $this->belongsTo(User::class, 'last_update_by');
    }
}