<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Managements\ManagementProjectProgress;
use App\Models\Users\User;
use App\Mail\AdminDailyDigestMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendAdminDigest extends Command
{
    protected $signature = 'admin:send-digest';
    protected $description = 'Send daily progress recap to admin';

    public function handle()
    {
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        
        $progressLogs = ManagementProjectProgress::whereDate('created_at', $today)
            ->with(['task', 'user'])
            ->get();

        if ($progressLogs->isEmpty()) {
            $this->info('No progress uploaded today.');
            return;
        }

        $admins = User::whereHas('userRole', function($q) {
            $q->where('name', 'Admin');
        })->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)->send(new AdminDailyDigestMail($progressLogs));
        }

        $this->info('Digest sent to admins.');
    }
}