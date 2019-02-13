<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Company;

class AddPoints
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $company;
    public $action;
    public $limit_type;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($company, $action, $limit_type)
    {
        $this->company = $company;
        $this->action = $action;
        $this->limit_type = $limit_type;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
