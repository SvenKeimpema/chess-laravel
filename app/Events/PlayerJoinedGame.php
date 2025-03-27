<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class PlayerJoinedGame implements ShouldBroadcast {
    use Dispatchable;

    /**
     * The id of the game for the player.
     * @var int
     */
    protected $game_id;

    public function __construct(int $game_id) {
        $this->game_id = $game_id;
    }

    /**
     * this is the id of the player that is currently inside of the matchmaking loop, we will create a channel for every player that is inside this matchmaking
     * @var int
     */
    public function broadcastOn() {
        return new PrivateChannel("Game.{$this->game_id}");
    }
}
