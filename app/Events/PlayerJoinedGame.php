<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PlayerJoinedGame implements ShouldBroadcast {
       use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * this is the id of the player that is currently inside of the matchmaking loop, we will create a channel for every player that is inside this matchmaking
     * @var integer
     */
    public $gameId;

    public function __construct($gameId)
    {
        $this->gameId = $gameId;
    }

    public function broadcastAs()
    {
        return 'PlayerJoinedGame';
    }

    public function broadcastOn() {
        return new Channel("Game." . $this->gameId);
    }
}
