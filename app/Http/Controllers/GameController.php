<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\PieceMovement\GameStatus;
use App\Http\Controllers\PieceMovement\PieceSide;
use App\Models\GameTurn;
use App\Models\Matchmaking;
use App\Models\UserGames;
use App\Models\User;
use Auth;
use PHPUnit\Exception;

class GameController {
    private GameStatus $gameStatus;
    private PieceSide $pieceSide;

    public function __construct() {
        $this->gameStatus = new GameStatus();
        $this->pieceSide = new PieceSide();
    }

    /**
     * Gets the id of the game the user is currently in.
     *
     * @return int|null The game ID or null if the user is not in a game.
     */
    public function current_game(): int|null {
        $current_game = UserGames::where(["user_id" => Auth::user()->id, "ended" => false])->latest()->first();
        if($current_game) $current_game->game_id;
        $match = Matchmaking::where(["user_id" => Auth::user()->id])->first();
        if($match) return $match->game_id;

        return UserGames::where(["user_id" => Auth::user()->id])->latest()->first()->game_id;
    }

    /**
     * Checks if it's the current user's turn.
     *
     * @return bool True if it's the user's turn, false otherwise.
     */
    public function current_turn(): bool {
        $game_id = $this->current_game();
        $current_turn = GameTurn::where("game_id", $game_id)->first();
        return $current_turn->turn == Auth::user()->id;
    }

    /**
     * Removes the user from the current match.
     *
     * @return void
     */
     public function end_game(): void {
        // Check if the game can be ended (it needs to be a draw or win)
        $side = $this->pieceSide->current_side();
        $status = $this->gameStatus->status($side);
        if ($status->getData()->win || $status->getData()->draw) {
            $game_id = $this->current_game();
            UserGames::where("game_id", $game_id)->update(["ended" => true]);
        } else {
            throw new \Exception("The game cannot be ended as it is neither a draw nor a win.");
        }
    }

    public function get_player_names(): JsonResponse {
        $game_id = $this->current_game();
        $players = [];
        $names = [];
        $game = GameTurn::where("game_id", $game_id)->first();
        if($game->side) {
            $players[0] = $game->turn;
            $players[1] = UserGames::where("game_id", $game_id)->where("user_id", "!=", $game->turn)->first()->user_id;
        }else {
            $players[0] = UserGames::where("game_id", $game_id)->where("user_id", "!=", $game->turn)->first()->user_id;
            $players[1] = $game->turn;
        }

        foreach($players as $i => $player) {
            $names[$i] = User::where("id", $player)->first()->name;
        }

        return response()->json(["names" => $names]);
    }

    /**
     * Assigns a random starting side to one of the two users in a game and creates a new game turn.
     *
     * This function generates a random number (either 0 or 1) to determine which user will start the game.
     * It then creates a new game turn record in the database with the game ID, the user who will take the first turn,
     * and a flag indicating that the side has been assigned.
     *
     * @param int $game_id The ID of the game for which the turn is being created.
     *
     * @return void
     * @throws \Exception If there are not exactly 2 users for the given game ID.
     */
    public function create_random_side(int $game_id): void {
        $users = UserGames::where("game_id", $game_id)->get();

        // Assuming there are exactly 2 users in the matchmaking for the given game_id
        if ($users->count() == 2) {
            $user1_id = $users[0]->user_id;
            $user2_id = $users[1]->user_id;

            // You can now use $user1_id and $user2_id as needed
            $side = rand(0, 1);
            GameTurn::create([
                "game_id" => $game_id,
                "turn" => $side ? $user1_id : $user2_id,
                "side" => true,
            ]);
        } else {
            // Handle the case where there are not exactly 2 users
            throw new \Exception("Expected exactly 2 users for game_id: $game_id");
        }
    }
}
