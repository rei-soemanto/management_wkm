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
        // 1. Dapatkan data project internal dari event
        $internalProject = $event->project;

        // 2. Cek apakah project ini sudah pernah dipublish
        // Ini opsional tapi ide bagus untuk mencegah duplikat
        $existingPublicProject = Project::where('name', $internalProject->name)->first();
        
        if ($existingPublicProject) {
            // Project sudah ada, mungkin update saja?
            Log::warning("Project '{$internalProject->name}' sudah ada di tabel public projects. Update dilewati.");
            return;
        }

        // 3. Buat record baru di tabel 'projects' (public)
        try {
            Project::create([
                'name' => $internalProject->name,
                'description' => $internalProject->description,
                'last_updated_by' => Auth::id(), // Gunakan ID user yang sedang login
                // Tambahkan mapping kolom lain di sini
            ]);

            Log::info("Project '{$internalProject->name}' berhasil dipublish ke website public.");

        } catch (\Exception $e) {
            Log::error("Gagal mempublish project: " . $e->getMessage());
        }
    }
}