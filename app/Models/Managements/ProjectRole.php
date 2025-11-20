<?php

namespace App\Models\Managements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    use HasFactory;

    protected $table = 'project_roles';

    protected $fillable = ['name'];

    public function assignments()
    {
        return $this->hasMany(ManagementProjectRoleAssignment::class, 'role_id');
    }
}