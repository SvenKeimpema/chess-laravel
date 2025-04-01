<?php

namespace App\Http\Controllers;

use App\Models\Matchmaking;
use Auth;

class GameController {
    /**
     * gets the id of the game the user is currently in.
     * @return int|null
     */
    public function current_game(): int|null {
        return Matchmaking::where("user_id", Auth::user()->id)->first()->game_id;
    }
}
