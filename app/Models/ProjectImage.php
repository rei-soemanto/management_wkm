<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $table = 'project_images';

    protected $fillable = [
        'project_id',
        'image_path',
        'upload_order',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}