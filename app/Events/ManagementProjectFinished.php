<?php

namespace App\Events;

use App\Models\Managements\ManagementProject;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ManagementProjectFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\ManagementProject $project
     * @return void
     */
    public function __construct(ManagementProject $project)
    {
        $this->project = $project;
    }
}