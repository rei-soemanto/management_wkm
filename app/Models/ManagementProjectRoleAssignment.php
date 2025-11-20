<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagementProjectRoleAssignment extends Model
{
    use HasFactory;

    protected $table = 'management_project_role_assignments';

    protected $fillable = [
        'role_id',
        'user_id',
        'management_project_id',
    ];

    public function projectRole()
    {
        return $this->belongsTo(ProjectRole::class, 'role_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function managementProject()
    {
        return $this->belongsTo(ManagementProject::class, 'management_project_id');
    }
}