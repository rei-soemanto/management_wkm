<?php

namespace App\Listeners;

use App\Events\ManagementProjectFinished;
use App\Models\Projects\Project;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PublishProjectToPublicWebsite
{
    /**
     * Handle the event.
     *
     * @param \App\Events\ManagementProjectFinished $event
     * @return void
     */
    public function handle(ManagementProjectFinished $event)
    {
        // Get internal project data from event
        $internalProject = $event->project;

        // Check if project had published before
        $existingPublicProject = Project::where('name', $internalProject->name)->first();
        
        if ($existingPublicProject) {
            Log::warning("Project '{$internalProject->name}' already exist!");
            return;
        }

        // Create new record in table projects
        try {
            Project::create([
                'name' => $internalProject->name,
                'description' => $internalProject->description,
                'last_updated_by' => Auth::id(),
            ]);

            Log::info("Project '{$internalProject->name}' succesfully published to public site.");

        } catch (\Exception $e) {
            Log::error("Failed to publish project: " . $e->getMessage());
        }
    }
}