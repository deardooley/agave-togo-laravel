<?php

namespace App\Events\Frontend\Webhook;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IncomingWebhook
{
    use Dispatchable, SerializesModels;

    /**
     * @var string
     */
    public $resourceType;
    /**
     * @var string
     */
    public $event;
    /**
     * @var string
     */
    public $username;
    /**
     * @var string
     */
    public $uuid;
    /**
     * @var array
     */
    public $body;

    /**
     * Create a new event instance.
     *
     * @param string $resourceType
     * @param string $event
     * @param string $eventOwner
     * @param string $uuid
     * @param array $body
     */
    public function __construct(string $resourceType, string $event, string $username, string $uuid, array $body)
    {
        $this->resourceType = $resourceType;
        $this->event = $event;
        $this->username = $username;
        $this->uuid = $uuid;
        $this->body = $body;
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return $this->event;
    }
}
