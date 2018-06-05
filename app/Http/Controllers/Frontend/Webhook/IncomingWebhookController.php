<?php

namespace App\Http\Controllers;


use App\Events\Frontend\Webhook\IncomingWebhook;
use Illuminate\Http\Request;

class IncomingWebhookController extends Controller
{
    /**
     * Processes an incoming GET webhook request. An IncomingWebhookEvent is raised which may have
     * one or more listeners attached to take appropriate actions.
     *
     * @param Request $request
     * @param string $resourceType the type of resource. (ie. FILE, METADATA, JOB, etc)
     * @param string $event the event triggering the webhook (ie. CREATED, DELETED, UPLOADED, RUNNING, etc)
     * @param string $eventOwner The user attributed to the event.
     * @param string $uuid
     * @return void
     */
    public function index(Request $request, string $resourceType, string $event, string $eventOwner, string $uuid)
    {
        \Log::debug(json_encode(['headers' => $request->headers->all(), 'url' => $request->getRequestUri(), 'query' => $request->query->all()], JSON_PRETTY_PRINT));

        event(new IncomingWebhook($resourceType, $event, $eventOwner, $uuid, $request->query->all()));
    }

    /**
     * Processes an incoming POST webhook request. An IncomingWebhookEvent is raised which may have
     * one or more listeners attached to take appropriate actions.
     *
     * @param Request $request
     * @param string $resourceType the type of resource. (ie. FILE, METADATA, JOB, etc)
     * @param string $event the event triggering the webhook (ie. CREATED, DELETED, UPLOADED, RUNNING, etc)
     * @param string $eventOwner The user attributed to the event.
     * @param string $uuid
     * @return void
     */
    public function store(Request $request, string $resourceType, string $event, string $eventOwner, string $uuid)
    {
        \Log::debug(json_encode(['headers' => $request->headers->all(), 'url' => $request->getRequestUri(), 'query' => $request->query->all()], JSON_PRETTY_PRINT));

        event(new IncomingWebhook($resourceType, $event, $eventOwner, $uuid, $request->all()));
    }
}
