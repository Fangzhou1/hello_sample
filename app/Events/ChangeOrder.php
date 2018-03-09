<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Models\Settlement;
use App\Models\User;


class ChangeOrder implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $user;
    public $settlementid;
    public $mes;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$settlementid,$mes)
    {
        $this->user=$user;
        $this->settlementid=$settlementid;
        $this->mes=$mes;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['all'];
    }

    public function broadcastWith()
    {
        return ['name' => $this->user->name,'order_number'=>$this->settlementid,'mes'=>$this->mes];
    }
}
