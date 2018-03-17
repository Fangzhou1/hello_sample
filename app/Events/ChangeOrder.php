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
    public $mes2;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user,$settlementid,$mes,$mes2="")
    {
        $this->user=$user;
        $this->settlementid=$settlementid;
        $this->mes=$mes;
        $this->mes2=$mes2;
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
        return ['name' => $this->user->name,'order_number'=>$this->settlementid,'mes'=>$this->mes,'mes2'=>$this->mes2];
    }
}
