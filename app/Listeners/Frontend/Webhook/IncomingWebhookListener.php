<?php

namespace App\Listeners\Frontend\Webhook;

use App\Events\Frontend\Webhook\IncomingWebhook;
use App\Models\Auth\User;
use App\Notifications\IncomingWebhookNotification;

class IncomingWebhookListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  IncomingWebhook  $event
     * @return void
     */
    public function handle(IncomingWebhook $event)
    {
        $user = User::where('username', $event->username)->first();

        $user->notify(new IncomingWebhookNotification($event));
    }
}
