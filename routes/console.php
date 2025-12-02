<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

$phpBin = '/usr/local/bin/ea-php82';
$artisanFile = base_path('artisan');

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('tasks:send-reminders')->everyMinute()
    // ->dailyAt('09:00')
    // ->timezone('Asia/Jakarta');
    ->appendOutputTo(storage_path('logs/scheduler_output.log'));

Schedule::command('admin:send-digest')
    ->dailyAt('20:00')
    ->timezone('Asia/Jakarta')
    ->appendOutputTo(storage_path('logs/scheduler_output.log'));