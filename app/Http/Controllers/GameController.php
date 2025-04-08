<?php

namespace App\Http\Controllers;

use App\Models\GameTurn;
use App\Models\Matchmaking;
use Auth;
use PHPUnit\Exception;

class GameController {
    /**
     * gets the id of the game the user is currently in.
     * @return int|null
     */
    public function current_game(): int|null {
        return Matchmaking::where("user_id", Auth::user()->id)->first()->game_id;
    }

    /**
    * gets the current side of the game(white to move or black to move)
    * this does only work if the user is currently inside a game
    * @return int|null
    */
    public function current_side(): bool {
        $game_id = $this->current_game();
        $current_turn = GameTurn::where("game_id", $game_id)->first();
        return $current_turn->side;
    }

    /**
    * Assigns a random starting side to one of the two users in a game and creates a new game turn.
    *
    * This function generates a random number (either 0 or 1) to determine which user will start the game.
    * It then creates a new game turn record in the database with the game ID, the user who will take the first turn,
    * and a flag indicating that the side has been assigned.
    *
    * @param int $game_id The ID of the game for which the turn is being created.
    * @param int $user1 The ID of the first user.
    * @param int $user2 The ID of the second user.
    *
    * @return void
    */
    public function create_random_side(int $game_id): void {
        $users = Matchmaking::where("game_id", $game_id)->get();

        // Assuming there are exactly 2 users in the matchmaking for the given game_id
        if ($users->count() == 2) {
            $user1_id = $users[0]->id;
            $user2_id = $users[1]->id;

            // You can now use $user1_id and $user2_id as needed
            $side = rand(0, 1);
            GameTurn::create([
                "game_id" => $game_id,
                "turn" => $side ? $user1_id : $user2_id,
                "side" => true,
            ]);
        } else {
            // Handle the case where there are not exactly 2 users
            throw new Exception("Expected exactly 2 users for game_id: $game_id");
        }
    }
}
