<?php

namespace App\Listeners;

use App\Events\AddPoints;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use \App\Repositories\ProjectFunctions;

class PointsReward
{
    /**
     * Handle company created events.
     */
    public function onCompanyCreated(AddPoints $event) {
        $action = new ProjectFunctions;
        $action->addPoints($event->action, $event->company, $event->limit_type);
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\AddPoints',
            'App\Listeners\PointsReward@onCompanyCreated'
        );
    }
}