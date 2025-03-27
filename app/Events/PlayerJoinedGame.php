<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast; 
use Illuminate\Foundation\Events\Dispatchable;

class PlayerJoinedGame implements ShouldBroadcast {
    use Dispatchable;

    /**
     * this is the id of the player that is currently inside of the matchmaking loop, we will create a channel for every player that is inside this matchmaking
     * @var integer
     */
    public $game_id;

    public function broadcastOn() {
        return new PrivateChannel("Game.{$this->game_id}");
    }
}