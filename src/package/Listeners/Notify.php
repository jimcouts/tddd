<?php

namespace PragmaRX\Tddd\Package\Listeners;

use Notification;
use PragmaRX\Tddd\Package\Events\TestsFailed;
use PragmaRX\Tddd\Package\Notifications\Status;

class Notify
{
    /**
     * @return static
     */
    private function getNotifiableUsers()
    {
        return collect(config('tddd.notifications.users.emails'))->map(function ($item) {
            $model = instantiate(config('tddd.notifications.users.model'));

            $model->email = $item;

            return $model;
        });
    }

    /**
     * Handle the event.
     *
     * @param TestsFailed $event
     *
     * @return void
     */
    public function handle(TestsFailed $event)
    {
        Notification::send(
            $this->getNotifiableUsers(),
            new Status($event->tests, $event->channel)
        );
    }
}
