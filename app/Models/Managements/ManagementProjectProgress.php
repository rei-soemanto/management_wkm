<?php

namespace App\Models\Managements;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementProjectProgress extends Model
{
    use HasFactory;

    protected $table = 'management_project_progress';

    protected $fillable = [
        'user_id',
        'management_project_id',
        'task_id',
        'progress_date',
        'document_path',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function managementProject()
    {
        return $this->belongsTo(ManagementProject::class, 'management_project_id');
    }

    public function task()
    {
        return $this->belongsTo(ManagementProjectTask::class, 'task_id');
    }
}