<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $table = 'status';

    protected $fillable = ['name'];

    public function managementProjects()
    {
        return $this->hasMany(ManagementProject::class, 'status_id');
    }

    public function projectProgressLogs()
    {
        return $this->hasMany(ManagementProjectProgress::class, 'status_id');
    }
}