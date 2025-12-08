<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

$phpBin = '/usr/local/bin/ea-php82';
$artisanFile = base_path('artisan');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('tasks:send-reminders')
    ->dailyAt('08:30')
    ->timezone('Asia/Jakarta')
    ->appendOutputTo('/home/thep2892/public_html/management.thewkm.com/storage/logs/scheduler_output.log')
    ->before(function () {
        Log::info('tasks:send-reminders scheduled to run at ' . now());
    })
    ->after(function () {
        Log::info('tasks:send-reminders finished at ' . now());
    });

Schedule::command('admin:send-digest')
    ->dailyAt('20:00')
    ->timezone('Asia/Jakarta')
    ->appendOutputTo('/home/thep2892/public_html/management.thewkm.com/storage/logs/scheduler_output.log')
    ->before(function () {
        Log::info('admin:send-digest scheduled to run at ' . now());
    })
    ->after(function () {
        Log::info('admin:send-digest finished at ' . now());
    });