<?php

namespace App\Models\Managements;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Managements\ManagementProjectProgress;

class ManagementProjectTask extends Model
{
    use HasFactory;

    protected $table = 'management_project_tasks';

    protected $fillable = [
        'management_project_id',
        'assigned_to',
        'name',
        'description',
        'status_id',
        'due_date',
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function project()
    {
        return $this->belongsTo(ManagementProject::class, 'management_project_id');
    }

    public function assigned()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function progressLogs()
    {
        return $this->hasMany(ManagementProjectProgress::class, 'task_id');
    }
}