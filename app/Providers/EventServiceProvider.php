<?php

namespace App\Providers;

// 1. Import class Event dan Listener Anda
use App\Events\ManagementProjectFinished;
use App\Listeners\PublishProjectToPublicWebsite;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        ManagementProjectFinished::class => [
            PublishProjectToPublicWebsite::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}