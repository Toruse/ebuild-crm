<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Models\User\User;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        'App\Events\UserMail' => [
            'App\Listeners\SendDataRegisterManagerMail',
        ],
        'App\Events\Project\PublishProjectEvent' => [
            'App\Listeners\Project\SendNotificationUsers',
        ],
        'App\Events\User\EndDatePricedEvent' => [
            'App\Listeners\User\SendInfoExtendPricedMailListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
