<?php

namespace App\Http\Controllers\PieceMovement;

use App\Models\GameTurn;
use App\Models\UserGames;
use Auth;

class PieceSide {
    /**
     * Gets the current side of the game (white to move or black to move).
     * This only works if the user is currently inside a game.
     *
     * @return bool True if it's white's turn, false if it's black's turn.
     */
    public function current_side(): bool {
        $game_id = UserGames::where(["user_id" => Auth::user()->id])->latest()->first()->game_id;
        $current_turn = GameTurn::where("game_id", $game_id)->first();
        return $current_turn->side == 1;
    }

    /**
     * Switches the side and turn to the other player.
     *
     * @return void
     */
    public function switch_side(): void {
        $game_id = UserGames::where(["user_id" => Auth::user()->id])->latest()->first()->game_id;
        $current_turn = GameTurn::where("game_id", $game_id)->first();
        $users = UserGames::where("game_id", $game_id)->get();
        $user1_id = $users[0]->user_id;
        $user2_id = $users[1]->user_id;

        GameTurn::where("game_id", $game_id)->update([
            "side" => $current_turn->side == 1 ? 0 : 1,
            "turn" => $current_turn->turn == $user1_id ? $user2_id : $user1_id
        ]);
    }
}
