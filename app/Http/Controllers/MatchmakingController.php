<?php

namespace App\Http\Controllers;

use App\Events\PlayerJoinedGame;
use App\Models\Game;
use App\Models\Matchmaking;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

/**
 * This is the controller that will handle people joining matches and allows us to create some form of 1v1 multiplayer chess match
 * However please note that this matchmaking controller does not use any kind of checking on how good someone is, with this anybody can join anybody
 */
class MatchmakingController extends Controller {
    /**
     * This function will join or create a match based on if there is a match for us to actually join.
     * This function will also send a message to the other user if the match is created and for him to 'join' the game(this basically just means
     * he needs to change the view to the game board)
     * @return \Inertia\Response|\Illuminate\Http\RedirectResponse
     */
    public function index(): \Inertia\Response|\Illuminate\Http\RedirectResponse {
        $current_match_state = $this->get_match_state();
        switch ($current_match_state) {
            case MatchState::PENDING:
                return Inertia::render("matchmaking/wait-screen");
            case MatchState::FOUND:
                return redirect("/play/human");
        }

        $game_id = $this->find_match();

        if(!$game_id) {
            $this->create_join_match();
            return Inertia::render("matchmaking/wait-screen");
        }

        $this->join_match($game_id);
        // we dispatch a event to the other user so that he also joins a game
        PlayerJoinedGame::dispatch($game_id);
        return redirect('/play/human');
    }

    /**
     * gets the id of the game the user is currently in.
     * @return int|null
     */
    public function current_game(): int|null {
        return Matchmaking::where("user_id", Auth::user()->id)->first()->game_id;
    }

    /**
     * return the current state of the match, these state can be NONE where the user isn't matchmaking or is inside a match, PENDING: the user is matchmaking
     * but no one else is connected to the match and there is FOUND where there is someone else connected to the match.
     * @return MatchState
     */
    private function get_match_state(): MatchState {
        // we first need to get the game we are in
        $match = Matchmaking::where("user_id", Auth::user()->id)->first();
        if(!$match) return MatchState::NONE;
        $connected_user_count = Matchmaking::where("game_id", $match->game_id)->count();
        if($connected_user_count == 1) return MatchState::PENDING;
        return MatchState::FOUND;
    }

    /**
     * returns true if we are currently inside a match
     * @return bool
     */

     private function existing_match(): bool  {
        $matchmaking = Matchmaking::where("user_id", Auth::user()->id)->first();

        return $matchmaking != null;
     }

    /**
     * will return the id of the match if we can find one else we will just return
     * @return int|null
     */
    private function find_match(): int|null {
        $match = Matchmaking::select('game_id', 'user_id')
            ->groupBy('game_id')
            ->havingRaw('COUNT(user_id) = 1')
            ->first();

        return $match ? $match->game_id : null;
    }

    /**
     * returns a error if we failed to join the match, since we should not be able to access this function before we are elegible to actually find the match.
     * @param integer $game_id
     * @return void
     */
    private function join_match($game_id): void {
        Matchmaking::create([
            "user_id" => Auth::user()->id,
            "game_id" => $game_id
        ]);
    }

    /**
     * this function will create a match which other people can join, this function will also make it so we join the created match/game
     * @return void
     */
    private function create_join_match(): void {
        // we want to simply create a game here and add the user to the matchmaking table, the game table will not need any parameters since of how are schema works
        $game = Game::create([]);
        Matchmaking::create([
            "game_id" => $game->id,
            "user_id" => Auth::user()->id
        ]);
    }
}

enum MatchState {
    case NONE;
    case PENDING;
    case FOUND;
}
