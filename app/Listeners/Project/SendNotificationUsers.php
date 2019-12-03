<?php

namespace App\Listeners\Project;

use Illuminate\Queue\InteractsWithQueue;
use App\Events\Project\PublishProjectEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\NotificationProjectService;

class SendNotificationUsers
{

    protected $notificationProjectService;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(NotificationProjectService $notificationProjectService)
    {
        $this->notificationProjectService = $notificationProjectService;
    }

    /**
     * Handle the event.
     *
     * @param  PublishProjectEvent  $event
     * @return void
     */
    public function handle(PublishProjectEvent $event)
    {
        $this->notificationProjectService->publishProject($event->project);
        return true;
    }
}
